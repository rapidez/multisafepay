<?php

namespace Rapidez\MultiSafePay\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        dd($request);
    }

    public function cancel(Request $request)
    {

    }
}
