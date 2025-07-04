<?php

use App\Models\Appointment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListMuaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController; // Import AuthController

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/portofolio/team', function () {
    return view('portofolio.team');
})->name('portofolio.team');

Route::get('/portofolio/wedding', function () {
    return view('portofolio.wedding');
})->name('portofolio.wedding');

Route::get('/portofolio/events', function () {
    return view('portofolio.events');
})->name('portofolio.event');

Route::get('/portofolio/class', function () {
    return view('portofolio.class');
})->name('portofolio.class');

Route::get('/syarat-dan-ketentuan', function () {
    return view('syarat');
})->name('syarat');

Route::get('/layanan-kami', function () {
    return view('layanan');
})->name('layanan');

Route::get('/testimoni', function () {
    return view('testimoni');
})->name('testimoni');

Route::get('/hubungi-kami', function () {
    return view('hubungi-kami');
})->name('hubungi-kami');

Route::get('/appointment', function () {
    return view('appointment');
})->name('appointment')->middleware('auth', 'role:user'); // Hanya user yang bisa akses
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store')->middleware('auth', 'role:user');
// New route for fetching appointments via AJAX
Route::get('/get-appointments', [AppointmentController::class, 'getAppointmentsByDate'])->name('get-appointments')->middleware('auth', 'role:user');

Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation')->middleware('auth', 'role:user');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store')->middleware('auth', 'role:user'); // Ubah ini untuk memicu pembayaran

// New route for fetching reservations via AJAX
Route::get('/get-reservations', [ReservationController::class, 'getReservationsByDate'])->name('get-reservations')->middleware('auth', 'role:user');

// Rute BARU untuk update status pembayaran dari frontend
Route::post('/update-payment-status', [ReservationController::class, 'updateStatusFromFrontend'])->name('update.payment.status');

// Rute untuk Midtrans Notifikasi (Webhook) - Hapus atau komentar jika tidak digunakan
// Route::post('/midtrans/notification', [ReservationController::class, 'handleNotification'])->name('midtrans.notification');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']); // Gunakan AuthController untuk login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Rute untuk logout

Route::get('/daftar-akun', function () {
    return view('auth.daftar');
})->name('daftar-akun');
Route::post('/daftar-akun/store', [UserController::class, 'store'])->name('daftar-akun.store');

// Rute untuk dashboard admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth', 'role:admin');

Route::get('/create/weddingbyadmin', function (){
    return view('dashboard.weddingbyadmin');
})->name('dashboard.weddingbyadmin');
Route::post('/weddingbyadmin/store' ,[DashboardController::class, 'weddingbyadmin'])->name('weddingbyadmin.store')->middleware('auth', 'role:admin');

Route::get('/create/regulerbyadmin', function (){
    return view('dashboard.regulerbyadmin');
})->name('dashboard.regulerbyadmin');
Route::post('/regulerbyadmin/store' ,[DashboardController::class, 'regulerbyadmin'])->name('regulerbyadmin.store')->middleware('auth', 'role:admin');


Route::get('/create/classbyadmin', function (){
    return view('dashboard.classbyadmin');
})->name('dashboard.classbyadmin');
Route::post('/classbyadmin/store' ,[DashboardController::class, 'classbyadmin'])->name('classbyadmin.store')->middleware('auth', 'role:admin');

// Rute untuk CRUD appointment
Route::get('dashboard/reservasi-wedding', [AppointmentController::class, 'indexwedding'])->name('dashboard.reservasi-wedding')->middleware('auth', 'role:admin');
Route::get('dashboard/reservasi-reguler', [AppointmentController::class, 'indexreguler'])->name('dashboard.reservasi-reguler')->middleware('auth', 'role:admin');
Route::get('/dashboard/edit-appointment/{appointment}', [AppointmentController::class, 'edit'])->name('dashboard.edit-appointment')->middleware('auth', 'role:admin');
Route::put('/dashboard/update-appointment/{appointment}', [AppointmentController::class, 'update'])->name('dashboard.update-appointment')->middleware('auth', 'role:admin');
Route::delete('/dashboard/delete-appointment/{appointment}', [AppointmentController::class, 'destroy'])->name('dashboard.delete-appointment')->middleware('auth', 'role:admin');


// Rute untuk CRUD reservation
Route::get('/dashboard/kelas-makeup', [ReservationController::class, 'index'])->name('dashboard.kelas-makeup')->middleware('auth', 'role:admin');
Route::get('/dashboard/edit-reservation/{reservation}', [ReservationController::class, 'edit'])->name('dashboard.edit-reservation')->middleware('auth', 'role:admin');
Route::put('/dashboard/update-reservation/{reservation}', [ReservationController::class, 'update'])->name('dashboard.update-reservation')->middleware('auth', 'role:admin');
Route::delete('/dashboard/delete-reservation/{reservation}', [ReservationController::class, 'destroy'])->name('dashboard.delete-reservation')->middleware('auth', 'role:admin');

Route::get('/dashboard/akun-admin', [UserController::class, 'indexadmin'])->name('dashboard.akun-admin')->middleware('auth', 'role:admin');

Route::get('dashboard/akun-admin/create', [UserController::class, 'createadmin'])->name('dashboard.create-admin')->middleware('auth', 'role:admin');

Route::post('/dashboard/akun-admin', [UserController::class, 'storeadmin'])->name('dashboard.store-admin')->middleware('auth', 'role:admin');

Route::get('/dashboard/akun-admin/{user}/edit', [UserController::class, 'editadmin'])->name('dashboard.edit-admin')->middleware('auth', 'role:admin');

Route::put('/dashboard/akun-admin/{user}', [UserController::class, 'updateadmin'])->name('dashboard.update-admin')->middleware('auth', 'role:admin');

Route::delete('/dashboard/akun-admin/{user}', [UserController::class, 'destroyadmin'])->name('dashboard.destroy-admin')->middleware('auth', 'role:admin');

