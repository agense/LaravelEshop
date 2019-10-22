@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1>My Orders</h1>
                <hr/>
                <div class="panel-body">
                <div class="md-header mb-3">Current Orders</div>    
                @if(count($currentOrders) > 0)    
                    @foreach($currentOrders as $order)
                    <div class="card border-secondary mb-3">
                            <div class="card-header side-split order-header">
                              <div>
                                  <span class="text-uppercase">Order Date: {{formatDate($order->created_at)}} |</span> 
                                  <span>Order# {{$order->order_nr}}</span>
                             </div>
                              <div>
                                <span>{!!orderStatus($order)!!}</span>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="side-split align-items-center">
                                  <div class="order-product-list">
                                    @foreach($order->products as $product)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="table-img">
                                            <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                                        </div> 
                                        <div>
                                            <a href="{{route('shop.show', $product->slug )}}" class="details-text">{{$product->name}}</a><br/>
                                            <span>{{$product->details}}</span>
                                        </div>
                                        <div><span class="bordered-qty">{{$product->pivot->quantity}}</span></div>
                                    </div>
                                    @endforeach
                                  </div>
                                  <div class="order-summary">
                                        <h2 class="mini-header">Order Summary</h2> 
                                        <div>Total: {{displayPrice($order->billing_total)}}</div>
                                        <div>Payment: {{orderPaymentStatus($order)}}</div>
                                        <div>Delivery: {{orderDeliveryStatus($order)}}</div>
                                        <div><a href="{{route('user.showOrder', $order->id)}}" class="mt-3 btn-dark-border-sm opn-create">
                                            Order Details <i class="fas fa-chevron-right ml-1"></i></a>
                                        </div>
                                  </div>
                              </div>
                            </div>
                    </div>
                    @endforeach
                    <div class="mt-5">
                            {{ $currentOrders->appends(request()->input())->links()}}
                    </div> 
                @else 
                <div class="no-items">There are no current orders.</div>
                @endif   
                </div>
               <div class="separator"></div>
                <!--Previous orders-->
                <div class="panel-body mb-5">
                        <div class="md-header mb-3">Previous Orders</div>    
                        @if(count($previousOrders) > 0)    
                            @foreach($previousOrders as $order)
                            <div class="card border-secondary mb-3">
                                    <div class="card-header side-split order-header order-complete">
                                      <div>
                                          <span class="text-uppercase">Order Date: {{formatDate($order->created_at)}} |</span> 
                                          <span>Order# {{$order->order_nr}}</span>
                                     </div>
                                      <div>
                                        <span>{!!orderStatus($order)!!}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                      <div class="side-split align-items-center">
                                          <div class="order-product-list">
                                            @foreach($order->products as $product)
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="table-img">
                                                    <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                                                </div> 
                                                <div>
                                                    <a href="{{route('shop.show', $product->slug )}}" class="details-text">{{$product->name}}</a><br/>
                                                    <span>{{$product->details}}</span>
                                                </div>
                                                <div><span class="bordered-qty">{{$product->pivot->quantity}}</span></div>
                                            </div>
                                            @endforeach
                                          </div>
                                          <div class="order-summary">
                                                <h2 class="mini-header">Order Summary</h2> 
                                                <div>Total: {{displayPrice($order->billing_total)}}</div>
                                                <div>Payment: {{orderPaymentStatus($order)}}</div>
                                                <div>Delivery: {{orderDeliveryStatus($order)}}</div>
                                                <div><a href="{{route('user.showOrder', $order->id)}}" class="mt-3 btn-dark-border-sm opn-create">
                                                    Order Details <i class="fas fa-chevron-right ml-1"></i></a>
                                                </div>
                                          </div>
                                      </div>
                                    </div>
                            </div>
                            @endforeach
                            <div class="mt-5">
                                    {{$previousOrders->appends(request()->input())->links()}}
                            </div> 
                        @else 
                        <div class="no-items">There are no previous orders.</div>
                        @endif   
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection