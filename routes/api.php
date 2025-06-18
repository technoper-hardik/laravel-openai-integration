<?php


use App\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Route;

Route::apiResource('support_tickets', SupportTicketController::class)->only(['index', 'show', 'store']);
