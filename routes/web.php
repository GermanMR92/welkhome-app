<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestauranteController;

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

Auth::routes();

Route::get('/', [RestauranteController::class, 'index'])->name('home');

Route::prefix('restaurante')->group(function() {
    Route::get('/new', [RestauranteController::class, 'new']);
    // Route::get('/getRestaurantes', [RestauranteController::class, 'getRestaurantes']);
    // Route::get('/get/{id}', [RestauranteController::class, 'get']);
    Route::get('/edit/{id}', [RestauranteController::class, 'edit'])->name('editForm');
    // Route::post('/store', [RestauranteController::class, 'store']);
    Route::get('/store/{id?}', [RestauranteController::class, 'store']);
    Route::delete('/destroy/{id}', [RestauranteController::class, 'destroy']);
});