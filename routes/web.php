<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/msp-return/success', function(Request $request) {
        return view('multisafepay::success');
    })->name('multisafepay.success');
    Route::get('/msp-return/cancel', function(Request $request) {
        return view('multisafepay::cancel', ['quoteId' => $request->get('quoteId')]);
    })->name('multisafepay.cancel');
});
