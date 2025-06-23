<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter lainnya
        $search = $request->query('search');
        $filterLayanan = $request->query('filter_layanan');
        $filterBulan = $request->query('filter_bulan');
        $filterTahun = $request->query('filter_tahun');

        // Query untuk appointments
        $appointmentsQuery = Appointment::select(
            'id_appointment as id',
            'nama',
            'nama_mua',
            'jenis_layanan',
            'tanggal_appointment as tanggal_booking',
            'waktu_appointment as waktu_booking',
            'status'
        );

        // Query untuk reservations
        $reservationsQuery = Reservation::select(
            'id_reservation as id',
            'nama',
            'nama_mua', // nama_mua di tabel reservations bisa nullable
            'jenis_layanan',
            'tanggal_reservation as tanggal_booking',
            'waktu_reservation as waktu_booking',
            'status'
        );

        // Terapkan filter layanan pada masing-masing query sebelum digabungkan
        if ($filterLayanan && $filterLayanan !== 'semua') {
            if ($filterLayanan === 'Make-up Class') {
                $appointmentsQuery->where('jenis_layanan', 'non-existent-type'); // Pastikan tidak ada hasil dari appointments
                $reservationsQuery->where('jenis_layanan', $filterLayanan);
            } else {
                $appointmentsQuery->where('jenis_layanan', $filterLayanan);
                $reservationsQuery->where('jenis_layanan', 'non-existent-type'); // Pastikan tidak ada hasil dari reservations
            }
        }

        $appointments = $appointmentsQuery->get(); //cite: luckyngrh/beautyworks-website/beautyworks-website-28786eb6f39b8b03428d9870f83d6d42ee3f9e07/app/Http/Controllers/DashboardController.php
        $reservations = $reservationsQuery->get(); //cite: luckyngrh/beautyworks-website/beautyworks-website-287866f39b8b03428d9870f83d6d42ee3f9e07/app/Http/Controllers/DashboardController.php

        // Gabungkan kedua koleksi
        $allBookings = $appointments->merge($reservations); //cite: luckyngrh/beautyworks-website/beautyworks-website-28786eb6f39b8b03428d9870f83d6d42ee3f9e07/app/Http/Controllers/DashboardController.php

        // Filter pencarian berdasarkan nama MUA
        if ($search) {
            $allBookings = $allBookings->filter(function ($booking) use ($search) {
                return isset($booking->nama_mua) && str_contains(strtolower($booking->nama_mua), strtolower($search));
            });
        }

        // Filter bulan
        if ($filterBulan && $filterBulan !== 'all') {
            $allBookings = $allBookings->filter(function ($booking) use ($filterBulan) {
                return Carbon::parse($booking->tanggal_booking)->month == $filterBulan;
            });
        }

        // Filter tahun
        if ($filterTahun && $filterTahun !== 'all') {
            $allBookings = $allBookings->filter(function ($booking) use ($filterTahun) {
                return Carbon::parse($booking->tanggal_booking)->year == $filterTahun;
            });
        }

        // Urutkan berdasarkan tanggal dan waktu
        $allBookings = $allBookings->sortBy(function ($booking) {
            return Carbon::parse($booking->tanggal_booking . ' ' . $booking->waktu_booking);
        });

        return view('dashboard.index', compact('allBookings', 'search', 'filterLayanan', 'filterBulan', 'filterTahun')); //cite: luckyngrh/beautyworks-website/beautyworks-website-28786eb6f39b8b03428d9870f83d6d42ee3f9e07/app/Http/Controllers/DashboardController.php
    }
}