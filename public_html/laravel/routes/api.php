<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// PayTR Bildirim URL - CSRF ve session middleware'siz
Route::post('/notification', [PaymentController::class, 'transactions'])->name('api.payment.notification');
