<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::resource('mahasiswa', MahasiswaController::class)->except(['show', 'create', 'edit']);
