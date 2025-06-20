<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListMuaController;
use App\Http\Controllers\AuthController; // Import AuthController

Route::get('/', function () {
    return view('home');
})->name('home');

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

Route::get('/reservasi', function () {
    return view('reservasi');
})->name('reservasi')->middleware('auth', 'role:user'); // Hanya user yang bisa akses

Route::get('/hubungi-kami', function () {
    return view('hubungi-kami');
})->name('hubungi-kami');

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
Route::get('/dashboard', function () {
    return view('dashboard.index'); 
})->name('dashboard')->middleware('auth', 'role:admin'); // Hanya admin yang bisa akses

Route::get('/dashboard/reservasi-reguler', function () {
    return view('dashboard.reservasi-reguler'); 
})->name('dashboard.reservasi-reguler')->middleware('auth', 'role:admin');

Route::get('/dashboard/reservasi-wedding', function () {
    return view('dashboard.reservasi-wedding'); 
})->name('dashboard.reservasi-wedding')->middleware('auth', 'role:admin');

Route::get('/dashboard/kelas-makeup', function () {
    return view('dashboard.kelas-makeup'); 
})->name('dashboard.kelas-makeup')->middleware('auth', 'role:admin');

Route::get('/dashboard/list-mua/create', function () {
    return view('list-mua.create');
})->name('list-mua.create')->middleware('auth', 'role:admin');

Route::get('/dashboard/list-mua', [ListMuaController::class, 'index'])->name('list-mua.index')->middleware('auth', 'role:admin');

Route::get('/list-mua/create', [ListMuaController::class, 'create'])->name('list-mua.create');

Route::post('/list-mua', [ListMuaController::class, 'store'])->name('list-mua.store');

Route::get('/list-mua/{mua}/edit', [ListMuaController::class, 'edit'])->name('list-mua.edit');

Route::put('/list-mua/{mua}', [ListMuaController::class, 'update'])->name('list-mua.update');

Route::delete('/list-mua/{mua}', [ListMuaController::class, 'destroy'])->name('list-mua.destroy');

Route::get('/dashboard/akun-admin', [UserController::class, 'indexadmin'])->name('dashboard.akun-admin')->middleware('auth', 'role:admin');

Route::get('dashboard/akun-admin/create', [UserController::class, 'createadmin'])->name('dashboard.create-admin')->middleware('auth', 'role:admin');

Route::post('/dashboard/akun-admin', [UserController::class, 'storeadmin'])->name('dashboard.store-admin')->middleware('auth', 'role:admin');

Route::delete('/dashboard/akun-admin/{user}', [UserController::class, 'destroyadmin'])->name('dashboard.destroy-admin')->middleware('auth', 'role:admin');
