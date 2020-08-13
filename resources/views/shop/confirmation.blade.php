@extends('layouts.app')

@section('content')
<div class="container">
    <div class="message-holder">
        <div class="message">
        <p class="alert alert-danger mb-4">
            !!! Note, this is a development application, all data is fake and no real orders can be made.
        </p>
        <h1 class="mb-4">Thank you for your order!</h1>
        <p><strong>Your order has been confirmed. Order number is {{$orderNr}}</strong></p>
        
        <p>A confirmation email has beed sent to your email address.</p>
        <p>We will inform you by email once your order is ready for pickup.</p>
        @if(Auth::user())
        <div>
            <p><strong>You can check your order here:</strong></p>
            <a href="{{route('user.orders.index')}}" class="button button-dark">My Orders</a>
        </div>
        @else 
        <div>
            <a href="/" class="button button-dark">Home</a>
        </div>    
        @endif
        </div>
    </div>
</div>
@endsection