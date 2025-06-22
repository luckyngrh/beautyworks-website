<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request) // Add Request $request
    {
        // Fetch all appointments with their associated user and MUA
        $appointmentsQuery = Appointment::with('user', 'mua');
        // Fetch all reservations with their associated user and MUA
        $reservationsQuery = Reservation::with('user', 'mua');

        // Apply search filter if a search term is present
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $appointmentsQuery->whereHas('mua', function ($q) use ($searchTerm) {
                $q->where('nama_mua', 'like', '%' . $searchTerm . '%');
            });

            $reservationsQuery->whereHas('mua', function ($q) use ($searchTerm) {
                $q->where('nama_mua', 'like', '%' . $searchTerm . '%');
            });
        }

        $appointments = $appointmentsQuery->get();
        $reservations = $reservationsQuery->get();

        // Combine appointments and reservations into a single collection
        $allBookings = $appointments->concat($reservations);

        // Sort the combined collection by date and then by time
        $sortedBookings = $allBookings->sortBy(function ($booking) {
            // Determine the correct date and time fields based on the model type
            $dateField = $booking instanceof Appointment ? 'tanggal_appointment' : 'tanggal_reservation';
            $timeField = $booking instanceof Appointment ? 'waktu_appointment' : 'waktu_reservation';

            // Create a Carbon instance for sorting
            return Carbon::parse($booking->$dateField . ' ' . $booking->$timeField);
        })->values(); // Re-index the collection after sorting

        return view('dashboard.index', compact('sortedBookings'));
    }
}