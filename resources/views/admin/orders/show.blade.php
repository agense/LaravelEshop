@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        @component('components.admin.button-header',['flex' => true]) 
            @if($order->status !== 'complete')
            <a href="{{route('admin.orders.process.show', $order->id)}}" class="btn btn-success btn-md" style="color:#fff">
                <i class="fa fa-arrow-circle-left pr-2"></i> Process Order
            </a>
            @else 
            <span class="badge badge-success">Order Completed</span>
            @endif
            @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.orders.index', 'text' => 'Orders'])
         @endcomponent
         @include('partials.order_partials.order-details-template')
    </div>
</div>
@endsection
