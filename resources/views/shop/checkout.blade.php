@extends('layouts.app')

@section('content')
<div class="container container-narrow mb-5">
    <h1 class="left-heading">Checkout</h1>
    <div class="separator"></div> 

    <!--Order Products-->
    <div class="checkout-table-container">
        <h2 class="mb-2">Your Order</h2>
        <div class="shadow-box mt-3">
            @include('partials.cart_partials.shopping-cart', ['totals' => $totals])
        </div>
    </div>

    <!--Discount Code section-->
    <div class="my-4">
        @include('partials.cart_partials.discount-entry', ['discount' => $totals['discount']]) 
    </div>
    <!--End Of Discount Code Section -->

    <!--Checkout Form -->
     @include('partials.forms.checkout-form')
     <!--End Of Checkout Form--> 
     <div class="notice"> 
        <p class="alert alert-danger">
            !!! Note, this is a development application, all data is fake and no real orders can be made.
        </p>
    </div>
</div>
@endsection
