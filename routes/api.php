<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\GaleryController;
use App\Http\Controllers\API\HomestayController;
use App\Http\Controllers\API\HomestayNearHospitalController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\FavoriteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);
Route::post('users/{id}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('/images/{filename}', function ($filename) {
    $path = public_path('images/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

Route::get('/homestay', [HomestayController::class, 'index']);

Route::get('/room', [RoomController::class, 'index']);

Route::get('/booking', [BookingController::class, 'index']);
Route::post('/booking', [BookingController::class, 'store']);


Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);
Route::put('reviews/{review}', [ReviewController::class, 'update']);
Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

Route::get('/review/{homestays_id}', [ReviewController::class, 'getReviewsByHomestaysId']);

Route::get('/galery', [GaleryController::class, 'index']);

Route::post('check-email', [UserController::class, 'checkEmail']);
Route::post('reset-password/{id}', [UserController::class, 'resetPassword']);

Route::get('/homestayhospital', [HomestayNearHospitalController::class, 'index']);

Route::get('/favorite', [FavoriteController::class, 'index']);
Route::post('/favorite', [FavoriteController::class, 'store']);
Route::delete('favorites/{favorite}', [FavoriteController::class, 'destroy']);
Route::get('/favorite/check/{homestay_id}', [FavoriteController::class, 'checkFavorite']);
