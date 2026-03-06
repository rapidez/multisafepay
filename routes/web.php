<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/msp-return/success', function(Request $request) {
        return view('multisafepay::success');
    })->name('multisafepay.success');
    Route::get('/msp-return/cancel', function(Request $request) {
        return view('multisafepay::cancel', ['quoteId' => $request->get('quoteId')]);
    })->name('multisafepay.cancel');

    // Multisafepay does not follow redirects for the notification url
    Route::any('multisafepay/connect/notification', function (Request $request): \Psr\Http\Message\ResponseInterface {
        $url = rtrim(config('rapidez.magento_url'), '/') . $request->getRequestUri();

        return Http::withHeaders([
            'X-Real-IP' => $request->ip(),
            'X-Forwarded-For' => $request->header('X-Forwarded-For', $request->ip()),
        ])
            ->send($request->method(), $url, [
                'query' => $request->query(),
                'json' => $request->json(),
            ])
            ->toPsrResponse();
    });
});
