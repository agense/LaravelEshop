@extends('layouts.app')

@section('content')
<div class="container">
    <div class="message-holder">
        <div class="message">
        <h1>Thank you for your order</h1>
        <p>A confirmation email has beed sent to your email address</p>
        <p class="alert alert-danger">
                !!! Note, this is a development application, all data is fake and no real orders can be made.
        </p>
        <a href="/" class="button button-dark">Home</a>
        </div>
    </div>
</div>
@endsection