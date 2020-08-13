@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.navigations.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="panel panel-default">   
                @if($itemCount > 0)
                <div class="card border-secondary mb-4">
                    <div class="side-split-header card-header">   
                        <span class="md-header">Wishlist has {{$itemCount}} {{$itemCount == 1 ? 'item' : 'items'}}</span>
                        <!-- REMOVE ALL ITEMS -->
                        @include('partials.forms.cart_forms.clear-wishlist-form')
                    </div>
                    <div class="wishlist cart-table w-100 card-body">
                        <div class="cart-table">
                            @foreach($wishlist as $item)
                                <div class="cart-table-row">
                                        <div class="cart-table-row-left">
                                            <a href="{{route('pages.shop.show', $item->slug )}}">
                                                <div class="cart-table-img">
                                                    <img src="{{asset($item->featured_image_link)}}" alt="product">
                                                </div>
                                            </a>    
                                            <div class="cart-item-details">
                                                <div class="cart-table-item">
                                                    <a href="{{route('pages.shop.show', $item->slug )}}" class="product-name">{{$item->name}}</a>
                                                </div>
                                                <div class="cart-table-details" class="product-name">{{$item->brand->name}}</div>
                                            </div> 
                                        </div>
                                        <div class="cart-table-row-right">
                                            <div class="cart-table-actions">
                                                <!-- REMOVE ITEM FROM WISHLIST-->
                                                @include('partials.forms.cart_forms.remove-from-wishlist-form')
                                                <!--MOVE ITEM TO CART-->
                                                @include('partials.forms.cart_forms.move-from-wishlist-to-cart-form')
                                            </div>
                                        <div class="cart-product-price text-right">{{$item->displayPrice()}}</div>
                                        </div>
                                    </div>
                            <!--end cart table row-->
                            @endforeach
                        </div>
                    </div>  
                </div>
                @else
                    <div class="no-items md-header text-center ml-3 mt-2 py-5">
                        Your wishlist is empty
                        <div class="mt-3"><a href="{{ route('pages.shop.index') }}" class="button button-dark">Start Shopping</a></div>
                    </div>
                @endif
                @if($itemCount > 0)
                <div class="mt-5">
                        {{$wishlist->appends(request()->input())->links()}}
                    </div> 
                @endif    
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection