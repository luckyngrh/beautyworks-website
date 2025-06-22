<?php

namespace App\Http\Controllers;
use App\Models\Reservation; 
use App\Models\ListMua; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $id_user = Auth::user()->id;

        $request->validate([
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
            'id_user' => $id_user,
            'id_mua' => null, // MUA akan dipilih saat edit oleh admin
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_reservation' => $request->tanggal_reservation,
            'waktu_reservation' => $request->waktu_reservation,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->back()->with('success', 'Reservation berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
    }
}