<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter lainnya
        $search = $request->query('search');
        $filterLayanan = $request->query('filter_layanan');
        // Set default filter bulan dan tahun ke bulan dan tahun saat ini
        $filterBulan = $request->query('filter_bulan', date('n')); // 'n' gives month without leading zeros
        $filterTahun = $request->query('filter_tahun', date('Y'));

        // Base query untuk appointments
        $appointmentsQuery = DB::table('appointments')->select(
            'id_appointment as id',
            'nama',
            'nama_mua',
            'jenis_layanan',
            'tanggal_appointment as tanggal_booking',
            'waktu_appointment as waktu_booking',
            'status',
            DB::raw("'appointment' as source_table")
        );

        // Base query untuk reservations
        $reservationsQuery = DB::table('reservations')->select(
            'id_reservation as id',
            'nama',
            'nama_mua',
            'jenis_layanan',
            'tanggal_reservation as tanggal_booking',
            'waktu_reservation as waktu_booking',
            'status',
            DB::raw("'reservation' as source_table")
        )->where('status','sukses');

        // Terapkan filter layanan sebelum union
        if ($filterLayanan && $filterLayanan !== 'semua') {
            if ($filterLayanan === 'Make-up Class') {
                // Hanya ambil reservations untuk Make-up Class
                $reservationsQuery->where('jenis_layanan', $filterLayanan);
                // Kosongkan appointments
                $appointmentsQuery->whereRaw('1 = 0');
            } else {
                // Untuk Make-up Wedding dan Make-up Reguler, ambil dari appointments
                $appointmentsQuery->where('jenis_layanan', $filterLayanan);
                // Kosongkan reservations
                $reservationsQuery->whereRaw('1 = 0');
            }
        }

        // Terapkan filter bulan dan tahun di level database
        if ($filterBulan && $filterBulan !== 'all') {
            $appointmentsQuery->whereMonth('tanggal_appointment', $filterBulan);
            $reservationsQuery->whereMonth('tanggal_reservation', $filterBulan);
        }

        if ($filterTahun && $filterTahun !== 'all') {
            $appointmentsQuery->whereYear('tanggal_appointment', $filterTahun);
            $reservationsQuery->whereYear('tanggal_reservation', $filterTahun);
        }

        // Gabungkan dengan UNION dan urutkan
        $allBookings = $appointmentsQuery
            ->unionAll($reservationsQuery)
            ->orderBy('tanggal_booking')
            ->orderBy('waktu_booking')
            ->get();

        // Filter pencarian berdasarkan nama MUA (dilakukan setelah union karena LIKE dengan union bisa kompleks)
        if ($search) {
            $allBookings = $allBookings->filter(function ($booking) use ($search) {
                return isset($booking->nama_mua) && str_contains(strtolower($booking->nama_mua), strtolower($search));
            });
        }

        return view('dashboard.index', compact('allBookings', 'search', 'filterLayanan', 'filterBulan', 'filterTahun'));
    }

    public function weddingbyadmin(Request $request){
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
            'nama_mua' => $request->nama_mua,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'status' => 'Dijadwalkan',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

        public function regulerbyadmin(Request $request){
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
            'nama_mua' => $request->nama_mua,
            'jenis_layanan' => $request->jenis_layanan,
            'tanggal_appointment' => $request->tanggal_appointment,
            'waktu_appointment' => $request->waktu_appointment,
            'status' => 'Dijadwalkan',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }
}