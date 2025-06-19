<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/syarat_dan_ketentuan', function () {
    return view('syarat');
})->name('syarat');

Route::get('/layanan_kami', function () {
    return view('layanan');
})->name('layanan');

Route::get('/reservasi', function () {
    return view('reservasi');
})->name('reservasi');