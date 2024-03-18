<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//
Route::view('/', 'auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');