<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

//
Route::resource('permissions', PermissionController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('admin.permissions');

//
Route::resource('roles', RoleController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('admin.roles');

//
Route::resource('users', UserController::class)->names('admin.users')
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('admin.users');;
Route::get('users/{user}/load-roles', [UserController::class, 'loadRoles'])->name('admin.users.load-roles');
Route::match(['get', 'post'], 'users/password/reset', [UserController::class, 'passwordReset'])->name('admin.users.password.reset');
Route::get('users/{document}/getByDocument', [UserController::class, 'getByDocument'])->name('admin.users.getByDocument');