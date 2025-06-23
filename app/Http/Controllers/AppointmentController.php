<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Import model Appointment
use App\Models\ListMua; // Import model ListMua
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class AppointmentController extends Controller
{
    public function indexreguler(Request $request) //
    {
        $appointments = Appointment::where('jenis_layanan', 'Make-up Reguler')
            ->orderBy('tanggal_appointment', 'asc') // atau 'desc' untuk urutan terbaru dulu
            ->get();
        return view('dashboard.reservasi-reguler', compact('appointments')); //
    }

    public function indexwedding(Request $request) //
    {
        $appointments = Appointment::where('jenis_layanan', 'Make-up Wedding')
            ->orderBy('tanggal_appointment', 'asc') // 
            ->get();

        return view('dashboard.reservasi-wedding', compact('appointments')); //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            'nama_mua' => 'string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
        ]);

        // 1. Cek tanggal kurang dari hari ini
        // Menggunakan Carbon untuk membandingkan tanggal
        if (Carbon::parse($request->tanggal_appointment)->isBefore(Carbon::today())) {
            return redirect()->back()->withErrors(['tanggal_appointment' => 'Tanggal appointment tidak bisa di masa lalu.'])->withInput();
        }

        // 2. Cek jam di antara 07.00 dan 17.00
        $waktu_appointment = Carbon::parse($request->waktu_appointment);
        $start_time = Carbon::createFromTimeString('07:00');
        $end_time = Carbon::createFromTimeString('17:00');

        if ($waktu_appointment->lt($start_time) || $waktu_appointment->gt($end_time)) {
            return redirect()->back()->withErrors(['waktu_appointment' => 'Jam appointment harus di antara 07.00 dan 17.00 WIB.'])->withInput();
        }

        // 3. Cek apakah tanggal dan jam sudah ada di database
        $existingAppointment = Appointment::where('tanggal_appointment', $request->tanggal_appointment)
                                        ->where('waktu_appointment', $request->waktu_appointment)
                                        ->exists();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['tanggal_waktu' => 'Tanggal dan jam appointment yang Anda pilih sudah terisi. Mohon pilih tanggal atau jam lain.'])->withInput();
        }

        Appointment::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => null,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->back()->with('success', 'Appointment berhasil dibuat! Mohon tunggu konfirmasi dari admin.');
    }

    public function edit($id_appointment)
    {
        $appointment = Appointment::findOrFail($id_appointment);

        return view('dashboard.edit-appointment', compact('appointment'));
    }

    public function update(Request $request, $id_appointment)
    {
        $appointment = Appointment::findOrFail($id_appointment);

        $rules = [
            'nama' => 'string|max:255',
            'kontak' => 'string|max:255',
            'nama_mua' => 'nullable|string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
            'status' => 'required|string|in:Menunggu Konfirmasi,Diproses,Selesai,Dibatalkan',
        ];

        // Custom validation for date
        if (Carbon::parse($request->tanggal_appointment)->isBefore(Carbon::today()->toDateString())) {
            return back()->withErrors(['tanggal_appointment' => 'Tanggal appointment tidak bisa diubah menjadi tanggal yang sudah lewat.'])->withInput();
        }

        $request->validate($rules);

        $appointment->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => null,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
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

    // New method for AJAX request to fetch appointments by date
    public function getAppointmentsByDate(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['error' => 'Tanggal tidak ditemukan.'], 400);
        }

        // Ubah baris ini:
        $appointments = Appointment::where('tanggal_appointment', $date)
                                    // ->where('id_user', Auth::id()) // Hapus baris ini
                                    ->orderBy('waktu_appointment')
                                    ->get();

        return response()->json(['appointments' => $appointments]);
    }

    public function storebyadmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'nama_mua' => 'required|string|max:255',
            'jenis_layanan' => 'required|string|max:255',
            'tanggal_appointment' => 'required|date',
            'waktu_appointment' => 'required|date_format:H:i',
        ]);

        // 1. Cek tanggal kurang dari hari ini
        if (Carbon::parse($request->tanggal_appointment)->isBefore(Carbon::today())) {
            return redirect()->back()->withErrors(['tanggal_appointment' => 'Tanggal appointment tidak bisa di masa lalu.'])->withInput();
        }

        // 2. Cek jam di antara 07.00 dan 17.00
        $waktu_appointment = Carbon::parse($request->waktu_appointment);
        $start_time = Carbon::createFromTimeString('07:00');
        $end_time = Carbon::createFromTimeString('17:00');

        if ($waktu_appointment->lt($start_time) || $waktu_appointment->gt($end_time)) {
            return redirect()->back()->withErrors(['waktu_appointment' => 'Jam appointment harus di antara 07.00 dan 17.00 WIB.'])->withInput();
        }

        // 3. Cek apakah tanggal dan jam sudah ada di database
        $existingAppointment = Appointment::where('tanggal_appointment', $request->tanggal_appointment)
                                        ->where('waktu_appointment', $request->waktu_appointment)
                                        ->exists();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['tanggal_waktu' => 'Tanggal dan jam appointment yang Anda pilih sudah terisi. Mohon pilih tanggal atau jam lain.'])->withInput();
        }

        Appointment::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'nama_mua' => $request->nama_mua,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->back()->with('success', 'Appointment berhasil dibuat!');
    }
}