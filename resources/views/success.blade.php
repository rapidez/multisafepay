@extends('rapidez::layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container">
        <msp-pending :order='@json($t_order)' v-cloak>
            <div slot-scope="{ completed, order }">
                <div v-if="completed">
                    @include('rapidez::checkout.steps.success')
                </div>
                <div v-else>
                    @include('multisafepay::pending')
                </div>
            </div>
        </msp-pending>
    </div>
@endsection
