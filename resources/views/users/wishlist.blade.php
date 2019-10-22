@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="panel panel-default">
            <h1>My Wishlist</h1>
            <hr/><br/>    
            <div class="row">
            @if($itemCount > 0)
            <div class="side-split-header">   
            <span class="md-header">Wishlist has {{$itemCount}} {{$itemCount == 1 ? 'item' : 'items'}}</span>
                  <!-- REMOVE ALL ITEMS -->
                <form action="{{route('user.wishlist.clear')}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn-dark-border-sm">Clear Wishlist</button>
                </form>
            </div>
            <div class="wishlist cart-table w-100">
                    <div class="cart-table">
                        @foreach($wishlist as $item)
                            <!--Cart table row-->
                            <div class="cart-table-row">
                                    <!--left-->
                                    <div class="cart-table-row-left">
                                        <a href="{{route('shop.show', $item->slug )}}">
                                            <div class="cart-table-img">
                                                <img src="{{asset('/img/products/'.$item->featured_image)}}" alt="product">
                                            </div>
                                        </a>    
                                            <div class="cart-item-details">
                                                <div class="cart-table-item">
                                                <a href="{{route('shop.show', $item->slug )}}">{{$item->brand->name}} | {{$item->name}}</a>
                                                </div>
                                            <div class="cart-table-details">{{$item->details}}</div>
                                            </div> 
                                    </div>
                                    <!--right-->
                                    <div class="cart-table-row-right">
                                        <div class="cart-table-actions">
                                            <!-- REMOVE ITEM FROM CART-->
                                            <form action="{{route('user.wishlist.remove', $item->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="cart-options">Remove</button>
                                            </form>
                                            <!--MOVE ITEM TO SAVE FOR LATER-->
                                        <form action="{{route('cart.moveToCart', $item->id)}}" method="POST">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="cart-options">Move to Cart</button>
                                            </form>
                                        </div>
                                    <div class="cart-product-price text-right">{{$item->displayPrice()}}</div>
                                    </div>
                                </div>
                           <!--end cart table row-->
                           @endforeach
                       </div>
                       <div class="mt-5">
                            {{$wishlist->appends(request()->input())->links()}}
                       </div> 
            </div>  
            @else
            <div class="no-items md-header ml-3">Your wishlist is empty</div>
            @endif
            </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection