@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.navigations.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1>My Orders</h1>
                <hr/>
                <div class="panel-body">
                <div class="md-header mb-3">Current Orders</div>    
                @if(count($currentOrders) > 0)    
                    @foreach($currentOrders as $order)
                      @include('partials.order_partials.order-card')
                    @endforeach
                    <div class="mt-5">
                        {{ $currentOrders->appends(request()->input())->links()}}
                    </div> 
                @else 
                <div class="no-items mb-5">There are no current orders.</div>
                @endif   
                </div>
                <!--Previous orders-->
                <div class="panel-body mb-5">
                        <div class="md-header mb-3">Previous Orders</div>    
                        @if(count($previousOrders) > 0)    
                            @foreach($previousOrders as $order)
                              @include('partials.order_partials.order-card')
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