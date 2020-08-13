@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.navigations.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1 class="md-header mb-4">Order Details</h1>
                    @include('partials.order_partials.order-details-template')
                </div>
            </div>
        </div>
    </div>
@endsection