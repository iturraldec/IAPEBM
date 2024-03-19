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
Route::get('roles/{role}/load-permissions', [RoleController::class, 'loadPermissions'])->name('admin.roles.load-permissions');

//
Route::resource('users', UserController::class)->names('admin.users')
  ->only(['index', 'store', 'update', 'destroy'])
  ->names('admin.users');;
Route::get('users/{user}/load-roles', [UserController::class, 'loadRoles'])->name('admin.users.load-roles');
Route::view('users/password/reset', 'auth.passwords.reset')->name('admin.users.password.reset');