<?php

use Illuminate\Support\Facades\Route;
use Rapidez\MultiSafePay\Controllers\PaymentController;

Route::middleware('web')->group(function () {
    Route::get('/msp-return/success', [PaymentController::class, 'success'])->name('multisafepay.success');
    Route::get('/msp-return/cancel', [PaymentController::class, 'cancel'])->name('multisafepay.cancel');
});
