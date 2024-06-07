<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductAPIController;
use App\Http\Controllers\CategoryAPIController;
use App\Http\Controllers\CalendarAPIController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getProducts', [ProductAPIController::class, 'index']);
Route::get('editProduct/{id}', [ProductAPIController::class, 'edit']);
Route::post('saveProduct/{id}', [ProductAPIController::class, 'update']);

Route::get('getCategories', [CategoryAPIController::class, 'index']);
Route::get('editCategory/{id}', [CategoryAPIController::class, 'edit']);
Route::post('saveCategory/{id}', [CategoryAPIController::class, 'update']);

Route::get('getCalendars', [CalendarAPIController::class, 'index']);
Route::get('editCalendar/{date}', [CalendarAPIController::class, 'edit']);
Route::post('saveCategory/{id}', [CalendarAPIController::class, 'update']);
