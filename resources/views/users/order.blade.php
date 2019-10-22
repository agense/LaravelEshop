@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1 class="md-header mb-4">Order Details</h1>
                <div class="card border-secondary mb-3">
                    <div class="card-header side-split">
                            <div><span class="text-uppercase">Order Date:</span>
                                {{formatDate($order->created_at)}} | Order#&nbsp;{{$order->order_nr}}
                            </div>
                            <div>{!!orderStatus($order)!!}</div>
                    </div>
                    <div class="card-body">
                    <div class="order-holder">
                            <div class="side-split">
                                    <div class="mb-3">
                                    <h3>Billing Info</h3>
                                    <div class="mini-separator-left"></div>
                                    {!! displayBillingInfo($order) !!}
                                    <br/>
                                    <h3>Order Payment Details</h3>
                                    <div class="mini-separator-left"></div>
                                    {!!displayPaymentDetails($order)!!}
                                    </div>
                                    <div class="mb-3">
                                    <h3>Order Totals</h3>
                                    <div class="mini-separator-left"></div>
                                    {!!displayOrderTotals($order)!!}
                                    </div>
                                </div>
                            <div class="my-4">
                                <hr/>
                                <h3>Order Products</h3>
                                <hr />
                                <div class="order-table">
                                    @foreach($products as $product)
                                    <div class="order-table-row">
                                        <div>
                                            <div class="cart-table-img">
                                                <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                                            </div> 
                                        </div>
                                        <div class="cart-item-details">
                                            <div class="cart-table-details"><a href="{{route('shop.show', $product->slug )}}">{{$product->name}}</a></div>
                                            <div>{{$product->details}}</div>
                                        </div> 
                                        <div class="cart-item-price">
                                            <span><strong>Item Price</strong></span>
                                            <span>{{displayPrice($product->pivot->item_price)}}</span>
                                        </div>
                                        <div class="cart-item-qty">
                                            <span><strong>Quantity</strong></span>
                                            <span>{{$product->pivot->quantity}}</span>
                                        </div>
                                    </div>
                                    @endforeach
                               </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection