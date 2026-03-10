<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/msp-return/success', function(Request $request) {
        return redirect(route('checkout.success', $request->query()), 308);
    })->name('multisafepay.success');

    Route::get('/msp-return/cancel', function(Request $request) {
        config('rapidez.models.quote')::query()
            ->withoutGlobalScopes()
            ->whereQuoteIdOrCustomerToken($request->input('quoteId', ''))
            ->update(['is_active' => 1]);

        return redirect('cart');
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

// Return multisafepay connect requests back to Magento.
// This usually means an incorrect setup.
Route::any('multisafepay/connect/{status}', fn($status) => redirect(url()->query(config('rapidez.magento_url').'/multisafepay/connect/' . $status, request()->query()), 308));
