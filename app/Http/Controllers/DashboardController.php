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
        // Fetch all appointments and alias columns for consistent merging
        $appointments = Appointment::select(
            'id_appointment as id',
            'nama',
            'nama_mua',
            'jenis_layanan',
            'tanggal_appointment as tanggal_booking',
            'waktu_appointment as waktu_booking',
            'status'
        )->get();

        // Fetch all reservations and alias columns for consistent merging
        $reservations = Reservation::select(
            'id_reservation as id',
            'nama',
            'nama_mua',
            'jenis_layanan',
            'tanggal_reservation as tanggal_booking',
            'waktu_reservation as waktu_booking',
            'status'
        )->get();

        // Merge both collections of bookings
        $allBookings = $appointments->merge($reservations);

        // Apply filters based on request
        $search = $request->query('search');
        $filterLayanan = $request->query('filter_layanan');
        $filterBulan = $request->query('filter_bulan');
        $filterTahun = $request->query('filter_tahun');

        // Search filter for MUA name
        if ($search) {
            $allBookings = $allBookings->filter(function ($booking) use ($search) {
                // Ensure nama_mua exists and contains the search term (case-insensitive)
                return isset($booking->nama_mua) && str_contains(strtolower($booking->nama_mua), strtolower($search));
            });
        }

        // Service type filter
        if ($filterLayanan && $filterLayanan !== 'semua') {
            $allBookings = $allBookings->where('jenis_layanan', $filterLayanan);
        }

        // Month filter for booking date
        if ($filterBulan && $filterBulan !== 'all') {
            $allBookings = $allBookings->filter(function ($booking) use ($filterBulan) {
                return Carbon::parse($booking->tanggal_booking)->month == $filterBulan;
            });
        }

        // Year filter for booking date
        if ($filterTahun && $filterTahun !== 'all') {
            $allBookings = $allBookings->filter(function ($booking) use ($filterTahun) {
                return Carbon::parse($booking->tanggal_booking)->year == $filterTahun;
            });
        }

        // Sort bookings by date and time for chronological display
        $allBookings = $allBookings->sortBy(function ($booking) {
            return Carbon::parse($booking->tanggal_booking . ' ' . $booking->waktu_booking);
        });

        // Pass filtered and sorted data along with current filter values to the view
        return view('dashboard.index', compact('allBookings', 'search', 'filterLayanan', 'filterBulan', 'filterTahun'));
    }
}