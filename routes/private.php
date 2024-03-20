<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

//
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'],'users/password/change', [UserController::class, 'passwordChange'])->name('users.password.change');