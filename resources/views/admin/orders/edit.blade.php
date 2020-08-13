@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">Process Order</h1>
@endsection
@section('content')

@component('components.admin.button-header',['flex' => true]) 
    <div>
        <div class="sm-header">
            <span class="text-uppercase">Order Nr:</span> {{$order->order_nr}}
        </div>
        <small><span class="text-uppercase mr-1">Order Date: {{$order->created_at}}</span></small>
    </div>
    <div>
        <a href="{{route('admin.orders.show', $order->id)}}" class="btn btn-success btn-md" style="color:#fff">
            <i class="fa fa-arrow-circle-left pr-2"></i> View Order
        </a>
        @include('partials.admin_partials.buttons.direction-btn',
        ['routeUrl' => 'admin.orders.index', 'text' => 'Orders'])
    </div>
@endcomponent

<!--Order Complete Alert-->
<div class="separator" style="margin-top:-1.5rem"></div>
@if($order->orderComplete())  
    <div class="alert alert-success">Order complete. No changes are allowed.</div>
@endif  

<div class="mb-5 order-holder">
    <div class="form-splitted">
    <div class="fm-left"> 
        <!--Payment Processing-->
       @component('components.admin.content-box')
            @slot('title')
                <div class="d-flex justify-content-between">
                    <span>Payment Details</span>
                    <span class="badge {{$order->orderPaid() ?'badge-success': 'badge-danger'}}">
                        {{$order->payment_status}}
                    </span>
                </div>    
            @endslot
            @slot('content')
                <div class="mb-3">
                    <strong>Payment Type:</strong> <span>{{$order->payment_type}}</span>
                    <div class="separator-narrow"></div>
                </div>
                <div class="d-block mb-2">
                    <strong class="text-uppercase">Billing Details</strong>
                    @include('partials.order_partials.order-billing-info')
                    <div class="separator-narrow"></div>
                </div>

                <div class="d-block mb-2">
                <strong class="text-uppercase">Totals</strong>
                @include('partials.order_partials.order-totals')
                <div class="separator-narrow"></div>
                </div>

                @if(!$order->orderPaid())  
                    <h4 class="mb-3 mt-4">Process Payment now</h4>
                    <button type="submit" class="btn btn-success btn-md d-block" 
                        data-toggle="modal" data-target="#order-payment-processing-modal">Process Payment</button> 
                @else
                    <strong class=" d-block text-uppercase mb-2">Payment Details</strong>
                    @include('partials.order_partials.payment-details', ['partialView' => true])  
                @endif 
            @endslot
        @endcomponent
        
    </div>
        <div class="fm-left">
            <!--Order Status Processing-->
            @component('components.admin.content-box', ['flex' => true])
                @slot('title')
                     <div>
                    <div>Order Status</div>
                        @if($order->orderReady())
                            <small>Ready On Date: {{$order->ready_at}}</small>
                        @endif
                     </div>
                    <span>@include('partials.order_partials.order-status-badge')</span>
                @endslot
                @slot('content')
                    @if(!$order->orderComplete())  
                          <button type="submit" class="btn btn-success btn-md d-block" 
                          data-toggle="modal" data-target="#order-status-processing-modal">Update Status</button>
                    @else 
                        <div class="order-info">Completion Date: {{$order->completed_at}}</div>
                    @endif
                @endslot
            @endcomponent
            <!--End Order Status Processing-->
            
            <!--Delivery Processing-->
            @component('components.admin.content-box')
                @slot('title')
                    Delivery Details
                @endslot
                @slot('content')
                    <div class="mb-3">
                        <div class="order-info">Delivery Type:</strong> <span>{{$order->delivery->delivery_type}}</div>
                    <div class="separator-narrow"></div>
                    </div>
                    <div class="mb-2">
                        <div class="order-info">Delivery Status: {{$order->delivery->delivery_status}}</div> 
                        @if($order->orderDelivered())
                            <div class="order-info">Delivery Date: {{$order->delivery->delivered_at}}</div>
                        @endif
                        <div class="separator-narrow"></div>
                    </div>
                    @if(!$order->orderDelivered())
                    <button type="submit" class="btn btn-success btn-md d-block" 
                        data-toggle="modal" data-target="#order-delivery-processing-modal">
                        Update Delivery Status
                    </button>
                    @else
                        <div class="order-info">Processsed By:</strong> {{$order->delivery->handler}}</div>
                    @endif
                @endslot
            @endcomponent
            <!--End Delivery Processing-->
        </div>
    </div>     
</div>    

@if(!$order->orderComplete())
    <!--Modals-->
    @include('partials.modals.order-processing-modal', ['type' => 'order-status-processing'])
    @include('partials.modals.order-processing-modal', ['type' => 'order-delivery-processing'])
    @include('partials.modals.order-processing-modal', ['type' => 'order-payment-processing'])
@endif
@endsection

@section('extra-footer')
    @if(!$order->orderComplete())
        <script type="text/javascript" src="{{ asset('js/admin/modal.order.processing.js')}}"></script>
        <script>
            (function(){
                initOrderProcessingModal('order-status-processing-modal', "{{route('admin.orders.process.status', $order->id)}}")
                initOrderProcessingModal('order-delivery-processing-modal', "{{route('admin.orders.process.delivery', $order->id)}}")
                initOrderProcessingModal('order-payment-processing-modal', "{{route('admin.orders.payment', $order->id)}}")
            })();
        </script>
    @endif
@endsection