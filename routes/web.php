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




use App\Http\Controllers\C_Locales;

// Ruta para mostrar todos los locales
Route::get('/locales', [C_Locales::class, 'index'])->name('locales.index');

// Ruta para mostrar el formulario de agregar un nuevo local
Route::get('/locales/create', [C_Locales::class, 'create'])->name('locales.create');

// Ruta para almacenar el nuevo local
Route::post('/locales', [C_Locales::class, 'store'])->name('locales.store');

// Ruta para mostrar el formulario de editar un local
Route::get('/locales/{id}/edit', [C_Locales::class, 'edit'])->name('locales.edit');

// Ruta para actualizar un local existente
Route::put('/locales/{id}', [C_Locales::class, 'update'])->name('locales.update');

// Ruta para eliminar un local
Route::delete('/locales/{id}', [C_Locales::class, 'destroy'])->name('locales.destroy');


use App\Http\Controllers\C_Plan;

// Ruta para mostrar todos los planes
Route::get('/planes', [C_Plan::class, 'index'])->name('planes.index');

// Ruta para mostrar el formulario de agregar un nuevo plan
Route::get('/planes/create', [C_Plan::class, 'create'])->name('planes.create');

// Ruta para almacenar el nuevo plan
Route::post('/planes', [C_Plan::class, 'store'])->name('planes.store');


use App\Http\Controllers\C_Eventos;
Route::prefix('eventos')->name('eventos.')->group(function () {
    Route::get('/', [C_Eventos::class, 'index'])->name('index');
    Route::get('/create', [C_Eventos::class, 'create'])->name('create');
    Route::post('/', [C_Eventos::class, 'store'])->name('store');
});

use App\Http\Controllers\C_Asientos;
Route::prefix('asientos')->name('asientos.')->group(function () {
    Route::get('/', [C_Asientos::class, 'index'])->name('index');
    Route::get('/create', [C_Asientos::class, 'create'])->name('create');
    Route::post('/', [C_Asientos::class, 'store'])->name('store');
});

use App\Http\Controllers\C_Tickets;
Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::get('/', [C_Tickets::class, 'index'])->name('index');
    Route::get('/create', [C_Tickets::class, 'create'])->name('create');
    Route::post('/', [C_Tickets::class, 'store'])->name('store');
});


Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [C_Usuarios::class, 'index'])->name('index');
    Route::get('/create', [C_Usuarios::class, 'create'])->name('create');
    Route::post('/', [C_Usuarios::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Usuarios::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Usuarios::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Usuarios::class, 'destroy'])->name('destroy');
});

// Incluye las rutas de autenticación generadas automáticamente
require __DIR__.'/auth.php';