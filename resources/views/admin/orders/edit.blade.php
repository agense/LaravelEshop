@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">Process Order</h1>
@endsection
@section('content')
<div class="side-split">
<h2>Order Nr: {{$order->order_nr}}</h2>
<div>Order Status: {!!orderStatus($order)!!}</div>
</div>
<div class="separator"></div>
<div class="mb-5 order-holder">
    @if($order->order_status !== 2)    
    <form action="{{route('admin.orders.update', $order->id)}}" method="POST">
    <div class="form-splitted">
    <div class="fm-left">  
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <h3>Process Payment</h3>
            @if($order->paid == 0)
            <div class="form-group">
                    <label for="paid">Payment Status</label>
                    <select name="paid" id="paid" class="form-control">
                        <option value="0" selected>Unpaid</option>
                        <option value="1">Paid</option>
                    </select>
            </div>
            <div class="form-group">
                    <label for="payment_type">Payment Type</label>
                    <select name="payment_type" id="payment_type" class="form-control">
                        <option value="cash" selected>Cash</option>
                        <option value="card">Card</option>
                    </select>
            </div>
            <div class="form-group">
               <label for="payment_date">Payment Date</label>
            <input  type="date" name="payment_date" id="payment_date" value="" class="form-control">
            </div>
            @else
            <div>Order Payment Status: <span class="badge badge-success">Paid</span></div>
            @endif
    </div>
    <div class="fm-left">
            <h3>Process Delivery</h3>
            <div class="form-group">
                    <label for="delivered">Delivery Status</label>
                    <select name="delivered" id="delivered" class="form-control">
                        <option value="0" {{$order->delivered == 0 ? "selected" : ""}}>In Progress</option>
                        <option value="1" {{$order->delivered == 1 ? "selected" : ""}}>Delivered</option>
                    </select>
            </div>
            <br/>
            <h3>Change Order Status</h3>
            <div class="form-group">
                    <label for="order_status">Order Status</label>
                    <select name="order_status" id="order_status" class="form-control">
                        @foreach($orderStatuses as $key => $value)
                        <option value="{{$value}}" {{ $order->order_status == $value ? "selected" : ""}}>{{$key}}</option>
                        @endforeach
                    </select>
            </div>
    </div>
    </div>    
    <div class="text-right mt-4">
            <a href="{{route('admin.orders.index')}}" class="btn btn-primary btn-md mr-2">Back</a> 
            <button type="submit" class="btn btn-success btn-md">Update Order</button>
            </div>
    </form>  
    @else 
    <span class="badge badge-success mb-3">Order Completed</span>
    <p>This order is completed. No changes are allowed.</p>
    @endif  
</div>             
@endsection
