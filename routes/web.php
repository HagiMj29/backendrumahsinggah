<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\HomestayNearHospitalController;
use App\Http\Controllers\ReviewController;
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

Route::get('review.index', [ReviewController::class, 'index'])->name('review.index');
Route::get('review.create', [ReviewController::class, 'create'])->name('review.create');
Route::post('review/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
Route::put('review/{review}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

Route::get('galery.index', [GaleryController::class, 'index'])->name('galery.index');
Route::get('galery.create', [GaleryController::class, 'create'])->name('galery.create');
Route::post('galery/review', [GaleryController::class, 'store'])->name('galery.store');
Route::get('galery/{galery}/edit', [GaleryController::class, 'edit'])->name('galery.edit');
Route::put('galery/{galery}', [GaleryController::class, 'update'])->name('galery.update');
Route::delete('galery/{galery}', [GaleryController::class, 'destroy'])->name('galery.destroy');

Route::get('favorite.index', [FavoriteController::class, 'index'])->name('favorite.index');
Route::get('favorite.create', [FavoriteController::class, 'create'])->name('favorite.create');
Route::post('favorite/review', [FavoriteController::class, 'store'])->name('favorite.store');
Route::get('favorite/{favorite}/edit', [FavoriteController::class, 'edit'])->name('favorite.edit');
Route::put('favorite/{favorite}', [FavoriteController::class, 'update'])->name('favorite.update');
Route::delete('favorite/{favorite}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

Route::get('homestayhospital.index', [HomestayNearHospitalController::class, 'index'])->name('homestayhospital.index');
Route::get('homestayhospital.create', [HomestayNearHospitalController::class, 'create'])->name('homestayhospital.create');
Route::post('homestayhospital/review', [HomestayNearHospitalController::class, 'store'])->name('homestayhospital.store');
Route::get('homestayhospital/{homestayhospital}/edit', [HomestayNearHospitalController::class, 'edit'])->name('homestayhospital.edit');
Route::put('homestayhospital/{homestayhospital}', [HomestayNearHospitalController::class, 'update'])->name('homestayhospital.update');
Route::delete('homestayhospital/{homestayhospital}', [HomestayNearHospitalController::class, 'destroy'])->name('homestayhospital.destroy'); 