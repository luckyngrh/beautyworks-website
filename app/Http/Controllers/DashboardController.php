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
}