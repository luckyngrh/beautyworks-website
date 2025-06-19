<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/syarat_dan_ketentuan', function () {
    return view('syarat');
})->name('syarat');
