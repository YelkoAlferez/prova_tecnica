<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\HomeController;

/**
 * Rutas protegidas por el middleware 'auth'
 */
Route::middleware(['auth'])->group(function () {

    //Rutas de pedidos
    Route::resource('calendar', CalendarController::class);

    // Rutas de categorias
    Route::resource('categories', CategoryController::class);

    // Rutas de productos
    Route::resource('products', ProductController::class);

    // Ruta de inicio
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Ruta de exportación de productos
    Route::get('product/export', [ExcelImportController::class, 'export'])->name('export');
});





Auth::routes();
