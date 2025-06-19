<?php

use Illuminate\Support\Facades\Route;

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
})->name('reservasi');

Route::get('/hubungi-kami', function () {
    return view('hubungi-kami');
})->name('hubungi-kami');