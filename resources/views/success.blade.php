@extends('rapidez::layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container" :set='order=@json($t_order)' :set2='order.customer_email=window.localStorage.email'>
        <graphql
            :query='`query { customer { orders ( filter: { number: { eq:"${order.increment_id}" } } ) { items { status } } }}`'
            v-cloak
        >
            <div slot-scope="{ data, runQuery, completed }" :set="completed=data?.customer?.orders?.items?.length&&['Voltooid', 'Completed'].includes(data.customer.orders.items[0].status)">
                <div v-if="completed">
                    @include('rapidez::checkout.steps.success')
                </div>
                <div v-else :set="window.setTimeout(()=>(completed||!data)?null:runQuery(), 2000)">
                    @include('multisafepay::pending')
                </div>
            </div>
        </graphql>
    </div>
@endsection
