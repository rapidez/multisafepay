@extends('rapidez::layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container" :set='order=@json($t_order)' :set2='order.customer_email=window.localStorage.email'>
        @include('rapidez::checkout.steps.success')
    </div>
@endsection
