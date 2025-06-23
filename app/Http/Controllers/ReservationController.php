<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\ListMua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::all();

        return view('dashboard.kelas-makeup', compact('reservations')); //
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            'nama_mua' => 'string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_reservation' => 'required|date',
            'waktu_reservation' => 'required|date_format:H:i',
        ]);

        // 1. Cek tanggal kurang dari hari ini
        // Menggunakan Carbon untuk membandingkan tanggal
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

        // 3. Cek apakah tanggal dan jam sudah ada di database
        $existingReservation = Reservation::where('tanggal_reservation', $request->tanggal_reservation)
            ->where('waktu_reservation', $request->waktu_reservation)
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['tanggal_waktu' => 'Tanggal dan jam reservation yang Anda pilih sudah terisi. Mohon pilih tanggal atau jam lain.'])->withInput();
        }

        Reservation::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => null,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_reservation' => $request->tanggal_reservation,
            'waktu_reservation' => $request->waktu_reservation,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->back()->with('success', 'Reservation berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
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
            'nama_mua' => 'nullable|string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_reservation' => 'required|date',
            'waktu_reservation' => 'required|date_format:H:i',
            'status' => 'required|string|in:Menunggu Konfirmasi,Diproses,Selesai,Dibatalkan',
        ];

        // Custom validation for date
        if (Carbon::parse($request->tanggal_reservation)->isBefore(Carbon::today()->toDateString())) {
            return back()->withErrors(['tanggal_reservation' => 'Tanggal reservation tidak bisa diubah menjadi tanggal yang sudah lewat.'])->withInput();
        }

        $request->validate($rules);

        $reservation->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => null,
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

        // Fetch reservations for 'Make-up Class' on the given date, ordered by time
        // And only for the authenticated user
        $reservations = Reservation::where('jenis_layanan', 'Make-up Class')
                                    ->where('tanggal_reservation', $date)
                                    ->where('id_user', Auth::id())
                                    ->orderBy('waktu_reservation')
                                    ->get();

        return response()->json(['reservations' => $reservations]);
    }
}