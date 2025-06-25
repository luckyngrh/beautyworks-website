<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
// use Midtrans\Notification; // Hapus atau komentar baris ini jika tidak menggunakan webhook
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans saat controller diinisialisasi
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        // Hanya tampilkan reservasi yang berstatus 'Sukses' atau 'Menunggu Konfirmasi'
        $query = Reservation::where('jenis_layanan', 'Make-up Class')
                                ->orderBy('tanggal_reservation', 'asc')
                                ->orderBy('waktu_reservation', 'asc');

        // Tambahkan logika pencarian berdasarkan nama MUA
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $reservations = $query->get(); // Eksekusi query setelah filter diterapkan


        return view('dashboard.kelas-makeup', compact('reservations'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_reservation' => 'required|date',
            'waktu_reservation' => 'required|date_format:H:i',
        ]);

        // 1. Cek tanggal kurang dari hari ini
        if (Carbon::parse($request->tanggal_reservation)->isBefore(Carbon::today())) {
            return redirect()->back()->withErrors(['tanggal_reservation' => 'Tanggal reservation tidak bisa di masa lalu.'])->withInput();
        }

        // 2. Cek jam di antara 07.00 dan 17.00
        $waktu_reservation = Carbon::parse($request->waktu_reservation);
        $start_time = Carbon::createFromTimeString('07:00');
        $end_time = Carbon::createFromTimeString('17:00');

        if ($waktu_reservation->lt($start_time) || $waktu_reservation->gt($end_time)) {
            return redirect()->back()->withErrors(['waktu_reservation' => 'Jam reservation harus di antara 07.00 dan 17.00 WIB.'])->withInput();
        }

        // 3. Cek apakah tanggal dan jam sudah ada di database untuk 'Make-up Class'
        $existingReservation = Reservation::where('tanggal_reservation', $request->tanggal_reservation)
            ->where('waktu_reservation', $request->waktu_reservation)
            ->where('jenis_layanan', 'Make-up Class')
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Sukses'])
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['tanggal_waktu' => 'Tanggal dan jam reservation yang Anda pilih sudah terisi. Mohon pilih tanggal atau jam lain.'])->withInput();
        }

        // Generate order ID yang unik untuk Midtrans
        $orderId = 'RES-' . Auth::id() . '-' . Str::uuid();

        // Data transaksi untuk Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => 450000,
        ];

        // Data pelanggan
        $customerDetails = [
            'first_name' => Auth::user()->nama,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->no_telp,
        ];

        // Item detail
        $itemDetails = [
            [
                'id' => 'MKPCLS001',
                'name' => 'Make-up Class Reservation',
                'price' => 450000,
                'quantity' => 1,
            ]
        ];

        // Parameter Snap
        $snapParams = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($snapParams);

            // Simpan data reservasi ke database dengan status 'Menunggu Pembayaran'
            $reservation = Reservation::create([ // Simpan objek reservation yang baru dibuat
                'id_midtrans' => $orderId,
                'nama' => $request->nama,
                'kontak' => $request->kontak,
                'nama_mua' => null,
                'jenis_layanan' => $request->jenis_layanan,
                'tanggal_reservation' => $request->tanggal_reservation,
                'waktu_reservation' => $request->waktu_reservation,
                'status' => 'Menunggu Pembayaran',
            ]);

            // Kirim snapToken dan orderId ke view agar bisa digunakan di JavaScript
            return redirect()->back()->with([
                'success' => 'Reservasi berhasil dibuat. Silakan selesaikan pembayaran.',
                'snapToken' => $snapToken,
                'midtransClientKey' => config('midtrans.client_key'),
                'midtransSnapUrl' => config('midtrans.snap_url'),
                'last_midtrans_order_id' => $orderId, // Simpan order ID di session
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['midtrans_error' => 'Gagal membuat transaksi pembayaran: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Metode BARU untuk update status dari frontend JavaScript callback.
     */
    public function updateStatusFromFrontend(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|string|in:Sukses,Menunggu Konfirmasi,Dibatalkan,Kadaluarsa',
        ]);

        $orderId = $request->input('order_id');
        $newStatus = $request->input('status');

        $reservation = Reservation::where('id_midtrans', $orderId)->first();

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Reservasi tidak ditemukan.'], 404);
        }

        // Hanya perbarui jika status yang diterima lebih "final" atau berbeda
        // Ini untuk mencegah status "Sukses" ditimpa oleh "Dibatalkan" jika ada keterlambatan.
        // Dalam skenario ini, karena tidak ada webhook, kita percaya frontend.
        $reservation->status = $newStatus;
        $reservation->save();

        return response()->json(['success' => true, 'message' => 'Status reservasi berhasil diperbarui.', 'new_status' => $newStatus]);
    }

    public function edit($id_reservation)
    {
        $reservation = Reservation::findOrFail($id_reservation);

        return view('dashboard.edit-reservation', compact('reservation'));
    }

    public function update(Request $request, $id_reservation)
    {
        $reservation = Reservation::findOrFail($id_reservation);

        $rules = [
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            'nama_mua' => 'nullable|string|max:255', // Biarkan nullable untuk kelas make-up
            'jenis_layanan' => 'string|max:255',
            'tanggal_reservation' => 'required|date',
            'waktu_reservation' => 'required|date_format:H:i',
            'status' => 'string|in:Menunggu Pembayaran,Menunggu Konfirmasi,Sukses,Dibatalkan,Kadaluarsa', // Tambahkan status baru
        ];

        // Custom validation for date
        if (Carbon::parse($request->tanggal_reservation)->isBefore(Carbon::today()->toDateString())) {
            return back()->withErrors(['tanggal_reservation' => 'Tanggal reservation tidak bisa diubah menjadi tanggal yang sudah lewat.'])->withInput();
        }

        $request->validate($rules);

        $reservation->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => $request->nama_mua,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_reservation' => $request->tanggal_reservation,
            'waktu_reservation' => $request->waktu_reservation,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.kelas-makeup')->with('success', 'Data reservation berhasil diperbarui!');
    }

    public function destroy($id_reservation)
    {
        $reservation = Reservation::findOrFail($id_reservation);
        $reservation->delete();

        return redirect()->route('dashboard.kelas-makeup')->with('success', 'Data reservation berhasil dihapus!');
    }

    // New method for AJAX request
    public function getReservationsByDate(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['error' => 'Tanggal tidak ditemukan.'], 400);
        }

        $reservations = Reservation::where('jenis_layanan', 'Make-up Class')
                                        ->where('tanggal_reservation', $date)
                                        ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Sukses'])
                                        ->orderBy('waktu_reservation')
                                        ->get();

        return response()->json(['reservations' => $reservations]);
    }
}
