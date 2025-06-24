<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Str; // Tambahkan ini untuk UUID

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
        $reservations = Reservation::where('jenis_layanan', 'Make-up Class')
                                ->whereIn('status', ['Sukses', 'Menunggu Konfirmasi'])
                                ->orderBy('tanggal_reservation', 'desc')
                                ->orderBy('waktu_reservation', 'desc')
                                ->get();

        return view('dashboard.kelas-makeup', compact('reservations'));
    }

    // Method yang sudah ada, kita akan memodifikasinya
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            // 'nama_mua' tidak diperlukan karena ini kelas make-up, bukan wedding/reguler
            'jenis_layanan' => 'required|string|max:255', // Pastikan ini 'Make-up Class'
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
        // dan statusnya bukan 'Dibatalkan' atau 'Kadaluarsa'
        $existingReservation = Reservation::where('tanggal_reservation', $request->tanggal_reservation)
            ->where('waktu_reservation', $request->waktu_reservation)
            ->where('jenis_layanan', 'Make-up Class') // Pastikan hanya cek untuk jenis layanan ini
            ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Sukses']) // Hanya jika statusnya bukan Dibatalkan/Kadaluarsa
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['tanggal_waktu' => 'Tanggal dan jam reservation yang Anda pilih sudah terisi. Mohon pilih tanggal atau jam lain.'])->withInput();
        }

        // Generate order ID yang unik untuk Midtrans
        // Kita gunakan kombinasi user ID dan timestamp atau UUID
        $orderId = 'RES-' . Auth::id() . '-' . Str::uuid(); // Menggunakan UUID agar lebih unik

        // Data transaksi untuk Midtrans
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => 450000, // Harga tetap Rp 450.000
        ];

        // Data pelanggan
        $customerDetails = [
            'first_name' => Auth::user()->nama,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->no_telp,
        ];

        // Item detail (opsional, tapi bagus untuk catatan transaksi di Midtrans dashboard)
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
            // dan sertakan order ID dari Midtrans
            Reservation::create([
                'id_midtrans' => $orderId, // Simpan order ID Midtrans di sini
                'nama' => $request->nama,
                'kontak' => $request->kontak,
                'nama_mua' => null, // Karena ini kelas make-up
                'jenis_layanan' => $request->jenis_layanan,
                'tanggal_reservation' => $request->tanggal_reservation,
                'waktu_reservation' => $request->waktu_reservation,
                'status' => 'Menunggu Pembayaran', // Status awal: Menunggu Pembayaran
            ]);

            // Kirim snapToken ke view agar bisa digunakan di JavaScript
            return redirect()->back()->with([
                'success' => 'Reservasi berhasil dibuat. Silakan selesaikan pembayaran.',
                'snapToken' => $snapToken,
                'midtransClientKey' => config('midtrans.client_key'), // Kirim client key juga
                'midtransSnapUrl' => config('midtrans.snap_url'), // Kirim snap URL
            ]);

        } catch (\Exception $e) {
            // Tangani error jika gagal membuat Snap Token
            return redirect()->back()->withErrors(['midtrans_error' => 'Gagal membuat transaksi pembayaran: ' . $e->getMessage()])->withInput();
        }
    }

    // Method untuk menangani notifikasi dari Midtrans (Webhook)
    public function handleNotification(Request $request)
    {
        // Inisialisasi notifikasi Midtrans
        $notif = new Notification();

        // Ambil data notifikasi
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Cari reservasi berdasarkan order ID Midtrans
        $reservation = Reservation::where('id_midtrans', $orderId)->first();

        // Jika reservasi tidak ditemukan, log dan keluar
        if (!$reservation) {
            \Log::error('Midtrans Notification: Reservation with order ID ' . $orderId . ' not found.');
            return response('Reservation not found', 404);
        }

        // Logic untuk update status reservasi berdasarkan status transaksi Midtrans
        if ($transaction == 'capture') {
            // Untuk pembayaran kartu kredit dengan status capture
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // Set status menjadi 'challenge' atau 'pending'
                    $reservation->status = 'Menunggu Konfirmasi';
                } else {
                    // Jika fraud_status == 'accept'
                    $reservation->status = 'Sukses';
                }
            }
        } elseif ($transaction == 'settlement') {
            // Untuk metode pembayaran non-kartu kredit yang sudah settlement
            $reservation->status = 'Sukses';
        } elseif ($transaction == 'pending') {
            // Jika pembayaran masih pending
            $reservation->status = 'Menunggu Pembayaran';
        } elseif ($transaction == 'deny') {
            // Jika pembayaran ditolak
            $reservation->status = 'Dibatalkan';
        } elseif ($transaction == 'expire') {
            // Jika transaksi kadaluarsa
            $reservation->status = 'Kadaluarsa';
        } elseif ($transaction == 'cancel') {
            // Jika transaksi dibatalkan
            $reservation->status = 'Dibatalkan';
        }

        $reservation->save(); // Simpan perubahan status ke database

        \Log::info('Midtrans Notification: Order ID ' . $orderId . ' status updated to ' . $reservation->status);

        return response('OK', 200);
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
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_reservation' => 'required|date',
            'waktu_reservation' => 'required|date_format:H:i',
            'status' => 'required|string|in:Menunggu Pembayaran,Menunggu Konfirmasi,Sukses,Dibatalkan,Kadaluarsa', // Tambahkan status baru
        ];

        // Custom validation for date
        if (Carbon::parse($request->tanggal_reservation)->isBefore(Carbon::today()->toDateString())) {
            return back()->withErrors(['tanggal_reservation' => 'Tanggal reservation tidak bisa diubah menjadi tanggal yang sudah lewat.'])->withInput();
        }

        $request->validate($rules);

        $reservation->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => null, // Tetap null untuk kelas make-up
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

        // Redirect ke halaman daftar reservasi yang sesuai
        if ($reservation->jenis_layanan == 'Make-up Wedding') {
            return redirect()->route('dashboard.reservasi-wedding')->with('success', 'Data reservation berhasil dihapus!');
        }
        return redirect()->route('dashboard.reservasi-reguler')->with('success', 'Data reservation berhasil dihapus!');
    }

    // New method for AJAX request
    public function getReservationsByDate(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['error' => 'Tanggal tidak ditemukan.'], 400);
        }

        // Ubah baris ini:
        $reservations = Reservation::where('jenis_layanan', 'Make-up Class')
                                        ->where('tanggal_reservation', $date)
                                        ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Konfirmasi', 'Sukses']) // Hanya tampilkan status yang aktif
                                        ->orderBy('waktu_reservation')
                                        ->get();

        return response()->json(['reservations' => $reservations]);
    }
}
