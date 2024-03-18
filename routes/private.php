<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

//
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('users/password/reset', [UserController::class, 'passwordReset'])->name('users.password.reset');
Route::post('users/password/reset', [UserController::class, 'passwordChange']);