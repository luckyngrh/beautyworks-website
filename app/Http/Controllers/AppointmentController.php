<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Import model Appointment
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Ambil id_user dari user yang sedang login
        $id_user = Auth::user()->id; // Menggunakan auth() untuk mendapatkan user yang sedang login
        $no_telp_user = Auth::user()->id; // Mengambil nomor telepon user yang sedang login

        // Cek apakah id_user dan no_telp_user ada
        if (!$id_user || !$no_telp_user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
        
        // Validasi input
        $request->validate([
            'id_user' => 'required|exists:users,id', // Validasi id_user harus ada di tabel users
            'jenis_layanan' => 'required|string|max:15',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
            'kontak' => 'required|string|max:255',
        ]);

        Appointment::create([
            'id_user' => $id_user,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'kontak' => $no_telp_user,
            'status' => 'Menunggu Konfirmasi', // Set default status
        ]);
    }
}
