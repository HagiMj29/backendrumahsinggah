<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\RoomController;
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

Route::get('room.index', [RoomController::class, 'index'])->name('room.index');
Route::get('room.create', [RoomController::class, 'create'])->name('room.create');
Route::post('room/store', [RoomController::class, 'store'])->name('room.store');
Route::get('room/{room}/edit', [RoomController::class, 'edit'])->name('room.edit');
Route::put('room/{room}', [RoomController::class, 'update'])->name('room.update');
Route::delete('room/{room}', [RoomController::class, 'destroy'])->name('room.destroy');

Route::get('booking.index', [BookingController::class, 'index'])->name('booking.index');
Route::get('booking.create', [BookingController::class, 'create'])->name('booking.create');
Route::post('booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
Route::put('booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
Route::delete('booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
Route::get('/booking/{booking}/checkout', [BookingController::class, 'checkout_page'])->name('booking.checkout_page');
Route::put('/booking/{booking}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');

