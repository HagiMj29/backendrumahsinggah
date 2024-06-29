<?php

use App\Http\Controllers\HomestayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('/');
Route::get('users.index', [UserController::class, 'index'])->name('users.index');
Route::get('users.create', [UserController::class, 'create'])->name('users.create');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('homestay.index', [HomestayController::class, 'index'])->name('homestay.index');
Route::get('homestay.create', [HomestayController::class, 'create'])->name('homestay.create');
Route::post('homestay/store', [HomestayController::class, 'store'])->name('homestay.store');
Route::get('homestay/{homestay}/edit', [HomestayController::class, 'edit'])->name('homestay.edit');
Route::put('homestay/{homestay}', [HomestayController::class, 'update'])->name('homestay.update');
Route::delete('homestay/{homestay}', [HomestayController::class, 'destroy'])->name('homestay.destroy');

