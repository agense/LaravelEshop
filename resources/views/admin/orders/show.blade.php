@extends('layouts.admin')

@section('content')
<div class="mb-4">
@if($order->order_status !== 2)
<a href="{{route('admin.orders.edit', $order->id)}}" class="btn btn-success">Process Order</a>
@else 
<span class="badge badge-success">Order Completed</span>
@endif
</div>
<div class="card border-secondary mb-3">
        <div class="card-header">
            <h2 class="card-title">Order Nr. {{$order->order_nr}}</h2>
        </div>
        <div class="card-body">
            <div class="order-holder">
                <div class="side-split">
                    <div>
                        <h3>Order Info</h3>
                        {!! displayOrderMainInfo($order) !!}
                    </div>
                    <div>
                        <h3>Billing Info</h3>
                        {!! displayOrderersInfo($order) !!}
                    </div>
                </div>
                <div>
                    <h3>Order Products</h3>
                    <div class="order-table">
                       <table class="table table-hover table-sm">
                       <thead><tr>
                        <th></th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                       </tr></thead>        
                       <!--Cart table row-->
                       @foreach($order->products as $product)
                         <tr>
                         <td>
                            <div class="table-img">
                            <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                            </div>
                        </td>    
                         <td>{{$product->id}}</td>
                         <td>{{$product->name}}</td>
                         <td>{{$product->details}}</td>
                         <!--Display price at the time of sale saved in pivot table-->
                         <td class="text-center">{{displayPrice($product->pivot->item_price)}}</td>
                         <td class="text-center">{{$product->pivot->quantity}}</td>
                         </tr>
                       @endforeach
                       <!--end cart table row-->
                        </table>
                        <hr />
                   </div>
                </div>
                <div class="mb-2 side-split">
                    <div>
                    <h3>Order Payment Details</h3>
                    {!!displayPaymentDetails($order)!!}
                    </div>
                    <div>
                    <h3>Order Totals</h3>
                    {!!displayOrderTotals($order)!!}
                    </div>
                </div>
                <hr/>
            </div>
        </div>
      </div>
@endsection
