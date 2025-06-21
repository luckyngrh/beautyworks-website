<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Import model Appointment
use App\Models\ListMua; // Import model ListMua
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class AppointmentController extends Controller
{
    public function indexreguler()
    {
        $appointments = Appointment::where('jenis_layanan', 'Make-up Reguler')
        ->with('user','mua')
        ->orderBy('tanggal_appointment', 'desc')
        ->get();

        return view('dashboard.reservasi-reguler', compact('appointments'));
    }

    public function indexwedding()
    {
        $appointments = Appointment::where('jenis_layanan', 'Make-up Wedding')
        ->with('user','mua')
        ->orderBy('tanggal_appointment', 'desc')
        ->get();

        return view('dashboard.reservasi-wedding', compact('appointments'));
    }

    public function store(Request $request)
    {
        $id_user = Auth::user()->id;
        $no_telp_user = Auth::user()->no_telp;

        $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
        ]);

        Appointment::create([
            'id_user' => $id_user,
            'id_mua' => null, // MUA akan dipilih saat edit oleh admin
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'kontak' => $no_telp_user,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->back()->with('success', 'Appointment berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
    }

    public function edit($id_appointment)
    {
        $appointment = Appointment::with('user', 'mua')->findOrFail($id_appointment);

        // Ambil MUA berdasarkan spesialisasi layanan yang sedang di-edit
        $availableMuas = ListMua::where('spesialisasi', 'like', '%' . $appointment->jenis_layanan . '%')->get();

        return view('dashboard.edit-appointment', compact('appointment', 'availableMuas'));
    }

    public function update(Request $request, $id_appointment)
    {
        $appointment = Appointment::findOrFail($id_appointment);

        $rules = [
            'id_mua' => 'nullable|exists:list_muas,id_mua',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
            'kontak' => 'required|string|max:20',
            'status' => 'required|string|in:Menunggu Konfirmasi,Diproses,Selesai,Dibatalkan',
        ];

        // Custom validation for date
        if ($request->tanggal_appointment < Carbon::today()->toDateString()) {
            return back()->withErrors(['tanggal_appointment' => 'Tanggal appointment tidak bisa diubah menjadi tanggal yang sudah lewat.'])->withInput();
        }

        $request->validate($rules);

        $appointment->update([
            'id_mua' => $request->id_mua,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'kontak' => $request->kontak,
            'status' => $request->status,
        ]);

        // Redirect ke halaman daftar reservasi yang sesuai
        if ($appointment->jenis_layanan == 'Make-up Wedding') {
            return redirect()->route('dashboard.reservasi-wedding')->with('success', 'Data appointment berhasil diperbarui!');
        }
        return redirect()->route('dashboard.reservasi-reguler')->with('success', 'Data appointment berhasil diperbarui!');
    }

    public function destroy($id_appointment)
    {
        $appointment = Appointment::findOrFail($id_appointment);
        $appointment->delete();

        // Redirect ke halaman daftar reservasi yang sesuai
        if ($appointment->jenis_layanan == 'Make-up Wedding') {
            return redirect()->route('dashboard.reservasi-wedding')->with('success', 'Data appointment berhasil dihapus!');
        }
        return redirect()->route('dashboard.reservasi-reguler')->with('success', 'Data appointment berhasil dihapus!');
    }
}