<?php

use App\Http\Controllers\SupportTicketUIController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/tickets', [SupportTicketUIController::class, 'index'])->name('tickets.index');
Route::post('/tickets', [SupportTicketUIController::class, 'store'])->name('tickets.store');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
