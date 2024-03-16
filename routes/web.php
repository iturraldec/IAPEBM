<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function(){
  Route::get('home', [HomeController::class, 'index']);
  Route::post('logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('permissions/load-data', [PermissionController::class, 'loadData'])->name('permissions.load-data');
  Route::resource('permissions', PermissionController::class);
  
  Route::get('roles/load-data', [RoleController::class, 'loadData'])->name('roles.load-data');
  Route::resource('roles', RoleController::class);
  Route::get('roles/{role}/load-permissions', [RoleController::class, 'loadPermissions'])->name('roles.load-permissions');
  
  Route::get('users/load-data', [UserController::class, 'loadData'])->name('users.load-data');
  Route::resource('users', UserController::class);
  Route::get('users/{user}/load-roles', [UserController::class, 'loadRoles'])->name('users.load-roles');
});