<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\C_Tickets;
use App\Http\Controllers\C_Asientos;


/*
Route::get('', function () {
    return view('welcome');
});*/
use App\Http\Controllers\C_Welcome;
Route::get('/', [C_Welcome::class, 'index']);
Route::get('/evento/{id}', [C_Welcome::class, 'show'])->name('evento.show');
Route::get('/all', [C_Welcome::class, 'all'])->name('evento.all');

Route::get('/dashboard', [C_Tickets::class, 'misTickets'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::get('/obtener/planes/{eventoId}', [C_Asientos::class, 'getPlanesByEvento']);


use App\Http\Controllers\C_Locales;

Route::prefix('/locales')->name('locales.')
    ->middleware([RoleMiddleware::class.':ADMIN,GESTOR']) // Solo ADMIN y GESTOR pueden acceder
    ->group(function () {
        Route::get('/', [C_Locales::class, 'index'])->name('index');
        Route::get('/create', [C_Locales::class, 'create'])->name('create');
        Route::post('/', [C_Locales::class, 'store'])->name('store');
        Route::get('/{id}/edit', [C_Locales::class, 'edit'])->name('edit');
        Route::put('/{id}', [C_Locales::class, 'update'])->name('update');
        Route::delete('/{id}', [C_Locales::class, 'destroy'])->name('destroy');
        Route::post('/{id}/ocultar', [C_Locales::class, 'ocultar'])->name('ocultar');
    });

use App\Http\Controllers\C_Plan;
Route::prefix('/planes')->name('planes.')->group(function () {
    Route::get('/', [C_Plan::class, 'index'])->name('index');
    Route::get('/create', [C_Plan::class, 'create'])->name('create');
    Route::post('/', [C_Plan::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Plan::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Plan::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Plan::class, 'destroy'])->name('destroy');
    Route::post('/{id}/ocultar', [C_Plan::class, 'ocultar'])->name('ocultar');
});

Route::get('/planes/{eventoId}', [C_Plan::class, 'getPlanesByEvento']);


use App\Http\Controllers\C_Eventos;
Route::prefix('/eventos')->name('eventos.')->group(function () {
    Route::get('/', [C_Eventos::class, 'index'])->name('index');
    Route::get('/create', [C_Eventos::class, 'create'])->name('create');
    Route::post('/', [C_Eventos::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Eventos::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Eventos::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Eventos::class, 'destroy'])->name('destroy');
    Route::get('/show', [C_Eventos::class, 'show'])->name('show');
    Route::post('/{id}/ocultar', [C_Eventos::class, 'ocultar'])->name('ocultar');
});

//use App\Http\Controllers\C_Asientos;

Route::prefix('asientos')->name('asientos.')->group(function () {
    Route::get('/', [C_Asientos::class, 'index'])->name('index');
    Route::get('/create', [C_Asientos::class, 'create'])->name('create');
    Route::post('/', [C_Asientos::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Asientos::class, 'edit'])->name('edit');
    Route::put('/{id}', [C_Asientos::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Asientos::class, 'destroy'])->name('destroy');
    Route::post('/{id}/ocultar', [C_Asientos::class, 'ocultar'])->name('ocultar');
});

//use App\Http\Controllers\C_Tickets;

Route::prefix('tickets')->name('tickets.')->group(function () {
    Route::post('/store', [C_Tickets::class, 'store'])->name('store');
    Route::get('/', [C_Tickets::class, 'index'])->name('index');
    Route::get('/create', [C_Tickets::class, 'create'])->name('create');
    Route::get('/ticket/{id}/{codigo}', [C_Tickets::class, 'mostrarTicket'])->name('ticket.mostrar');
    Route::get('/ticket/{id}/download', [C_Tickets::class, 'downloadPDF'])->name('ticket.downloadPDF');
    Route::get('/user-tickets', [C_Tickets::class, 'userTickets'])
    ->middleware('auth')
    ->name('usuarios.tickets'); // Agregamos un nombre a la ruta
    Route::get('/usuarios/{id}/tickets', [C_Tickets::class, 'TicketsTotalUser'])->name('usuariostotales.tickets');
});



Route::get('/asientos/{eventoId}', [C_Tickets::class, 'getAsientosByEvento']);
Route::get('/planes/{eventoId}', [C_Tickets::class, 'getPlanesByEvento']);

//pago stripe
use App\Http\Controllers\PaymentController;

Route::get('/payment/{planId}', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.createPaymentIntent');
Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook']);


use App\Http\Controllers\C_Usuarios;
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [C_Usuarios::class, 'index'])->name('index');
    Route::get('/create', [C_Usuarios::class, 'create'])->name('create');
    Route::post('/', [C_Usuarios::class, 'store'])->name('store');
    Route::get('/{id}/edit', [C_Usuarios::class, 'edit'])->name('edit');
Route::put('/{id}', [C_Usuarios::class, 'update'])->name('update');
    Route::delete('/{id}', [C_Usuarios::class, 'destroy'])->name('destroy');
});


//Route::get('/',[App\Http\Controllers\C_Qr::class, 'qr']);
//Route::get('/generar-qr/{id}', [C_Qr::class, 'qr']);

// Incluye las rutas de autenticación generadas automáticamente
require __DIR__.'/auth.php';