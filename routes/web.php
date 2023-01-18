<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/msp-return/success', function(Request $request) {
        $order = (object)[
            'increment_id' => $request->get('orderId'),
            'payment_method' => $request->get('paymentCode'),
        ];
        return view('multisafepay::success', ['t_order' => $order]);
    })->name('multisafepay.success');
    Route::get('/msp-return/cancel', function(Request $request) {
        return view('multisafepay::cancel', ['quoteId' => $request->get('quoteId')]);
    })->name('multisafepay.cancel');
});
