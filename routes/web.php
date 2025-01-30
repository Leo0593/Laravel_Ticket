<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::get('/obtener/planes/{eventoId}', [C_Asientos::class, 'getPlanesByEvento']);


use App\Http\Controllers\C_Locales;

Route::prefix('/locales')->name('locales.')->group(function () {
    Route::get('/', [C_Locales::class, 'index'])->name('index');
    Route::get('/create', [C_Locales::class, 'create'])->name('create');
    Route::post('/', [C_Locales::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Locales::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Locales::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Locales::class, 'destroy'])->name('destroy');

});

use App\Http\Controllers\C_Plan;
Route::prefix('/planes')->name('planes.')->group(function () {
    Route::get('/', [C_Plan::class, 'index'])->name('index');
    Route::get('/create', [C_Plan::class, 'create'])->name('create');
    Route::post('/', [C_Plan::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Plan::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Plan::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Plan::class, 'destroy'])->name('destroy');
});

Route::get('/planes/{eventoId}', [C_Plan::class, 'getPlanesByEvento']);


use App\Http\Controllers\C_Eventos;
Route::prefix('eventos')->name('eventos.')->group(function () {
    Route::get('/', [C_Eventos::class, 'index'])->name('index');
    Route::get('/create', [C_Eventos::class, 'create'])->name('create');
    Route::post('/', [C_Eventos::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Eventos::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Eventos::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Eventos::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\C_Asientos;
Route::prefix('asientos')->name('asientos.')->group(function () {
    Route::get('/', [C_Asientos::class, 'index'])->name('index');
    Route::get('/create', [C_Asientos::class, 'create'])->name('create');
    Route::post('/', [C_Asientos::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Asientos::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Asientos::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Asientos::class, 'destroy'])->name('destroy');
});

use App\Http\Controllers\C_Tickets;
Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::get('/', [C_Tickets::class, 'index'])->name('index');
    Route::get('/create', [C_Tickets::class, 'create'])->name('create');
    Route::post('/', [C_Tickets::class, 'store'])->name('store');
});

Route::get('/asientos/{eventoId}', [C_Tickets::class, 'getAsientosByEvento']);
Route::get('/planes/{eventoId}', [C_Tickets::class, 'getPlanesByEvento']);


use App\Http\Controllers\C_Usuarios;
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [C_Usuarios::class, 'index'])->name('index');
    Route::get('/{id}/edit', [C_Usuarios::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Usuarios::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Usuarios::class, 'destroy'])->name('destroy');
});

// Incluye las rutas de autenticación generadas automáticamente
require __DIR__.'/auth.php';