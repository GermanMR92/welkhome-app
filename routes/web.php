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

// Ruta para la autenticacion (Libreria laravel/ui)
Auth::routes();

// Ruta principal con el listado de restaurantes
Route::get('/', [RestauranteController::class, 'index'])->name('home');

// Rutas para manejar el CRUD de restaurante
Route::prefix('restaurante')->group(function() {
    Route::get('/new', [RestauranteController::class, 'new']);
    Route::get('/edit/{id}', [RestauranteController::class, 'edit'])->name('editForm');
    Route::post('/store', [RestauranteController::class, 'store']);
    Route::put('/store/{id?}', [RestauranteController::class, 'store']);
    Route::delete('/destroy/{id}', [RestauranteController::class, 'destroy']);
});