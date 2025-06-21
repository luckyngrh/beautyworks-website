<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Import model Appointment
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function indexwedding()
    {
        // Ambil data appointment untuk user yang sedang login
        // $appointments = Appointment::where('id_user', Auth::user()->id)->get();
        $appointments = Appointment::where('jenis_layanan', 'Make-up Wedding')
        ->orderBy('tanggal_appointment', 'desc')
        ->get();

        return view('dashboard.reservasi-wedding', compact('appointments'));
    }
    public function store(Request $request)
    {
        // Ambil id_user dari user yang sedang login
        $id_user = Auth::user()->id; // Menggunakan auth() untuk mendapatkan user yang sedang login
        $no_telp_user = Auth::user()->no_telp; // Mengambil nomor telepon user yang sedang login

        // Validasi input
        $request->validate([
            'jenis_layanan' => 'required|string|max:255', // Increased max length to accommodate longer service names
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
        ]);

        Appointment::create([
            'id_user' => $id_user,
            'id_mua' => $request->null,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'kontak' => $no_telp_user,
            'status' => 'Menunggu Konfirmasi', // Set default status
        ]);
    }
}