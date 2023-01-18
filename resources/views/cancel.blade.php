@extends('rapidez::layouts.app')

@section('title', 'Checkout')

@section('content')
    <graphql query='mutation { restoreQuote(input: {cart_id:"{{ $quoteId }}"}) }' check="restoreQuote" redirect="/checkout"></graphql>
@endsection
