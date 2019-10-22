@extends('layouts.app')

@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('landingpage')}}">Home</a>
    <span>></span>
    <a href="{{route('cart.index')}}">Cart</a>
</div>
</div> 
<!--End Breadcrumbs-->
<div class="cart-section container">
<div class="cart-holder">    
    <!--Error Display-->
    @if(session()->has('alert_message'))
    <div class="alert alert-warning">
        {{session()->get('alert_message')}}
    </div>    
    @endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
 <!--End Error Display-->
        @if(Cart::count() > 0)
        <div class="side-split mb-4">  
                <a href="{{ route('shop.index') }}" class="button button-dark">Continue Shopping</a> 
                <a href="{{route('cart.clear')}}" class="button button-dark">Clear Cart</a>
        </div>
        <h2>{{Cart::count()}} item(s) in shopping cart</h2> 
         <!--Cart table-->
        <div class="cart-table">
             <!--Cart table row-->
             @foreach(Cart::content() as $item)
            <div class="cart-table-row">
                <!--left-->
                <div class="cart-table-row-left">
                    <a href="{{route('shop.show', $item->model->slug )}}">
                        <div class="cart-table-img">
                            <img src="{{asset('/img/products/'.$item->model->featured_image)}}" alt="product">
                        </div>
                    </a>    
                        <div class="cart-item-details">
                            <div class="cart-table-item">
                            <a href="{{route('shop.show', $item->model->slug )}}">{{$item->model->brand->name}} | {{$item->model->name}}</a>
                            </div>
                        <div class="cart-table-details">{{$item->model->details}}</div>
                        </div> 
                </div>
                <!--right-->
                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <!-- REMOVE ITEM FROM CART-->
                        <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}<!--Change method from post to delete-->
                            <button type="submit" class="cart-options">Remove</button>
                        </form>

                        <!--MOVE ITEM TO SAVE FOR LATER-->
                        <form action="{{ route('cart.moveToWishlist', $item->rowId) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="cart-options" data-toggle="tooltip" data-placement="bottom" title="You need to be logged in to save items in the wishlist.">Move To Wishlist</button>
                        </form>

                    </div>
                    <div class="cart-product-quantity">
                    @if($item->model->availability > 0)    
                    <select name="quantity" id="quantity" class="quantity" data-id="{{ $item->rowId }}" data-product="{{$item->model->id}}">
                        @for($i =1; $i < $item->model->availability + 1; $i++)
                         <option {{ $item->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                        @endfor
                       </select>
                    @else
                    <span class="badge badge-danger">Sold Out</span>
                    @endif   
                    </div>
                <div class="cart-product-price">{{ displayPrice($item->subtotal) }}</div>
                </div>
            </div>
            @endforeach
            <!--end cart table row-->
        </div>
        <!--end of cart table-->
        <!--Totals Section-->
        <div class="cart-totals">
            <!--left-->
            <div class="cart-totals-left"></div>
            <!--Right-->
            <div class="cart-totals-right">
                <div class="cart-subtotals">
                    <span>Subtotal</span><br/>
                    <span>Tax</span><br/>
                    <span class="cart-totals-total">Total</span>
                </div>
                <div class="cart-totals-subtotal">
                    <span>{{ displayPrice(Cart::subtotal()) }}</span>
                    <span>{{ displayPrice(Cart::tax()) }}</span>
                    <span class="cart-totals-total">{{ displayPrice(Cart::total()) }}</span>
                </div>
            </div>
        </div>
        <!--End Totals Section-->
        <!--Cart Buttons-->
        <div class="cart-buttons">
            @if(auth()->user())
            <a href="{{ route('user.wishlist') }}" class="button button-black">Check Your Wishlist</a>
            <a href="{{ route('checkout.index') }}" class="button button-primary">Proceed To Checkout</a>
            @else
            <div></div>
            <div>
            <a href="{{ route('checkout.index') }}" class="button button-primary">Login & Checkout</a>
            <!--GUEST CHECKOUT LINK-->
            <a href="{{route('guestCheckout.index')}}" class="button button-dark">Checkout As A Guest</a>
            </div>
            @endif
        </div>
         <!--End Cart Buttons-->
         @else
           <h2>Your Cart Is Empty.</h2>
           <div class="separator my-4"></div>
           <div class="side-split mb-4"> 
                @if(auth()->user())
                <a href="{{ route('user.wishlist') }}" class="button button-black">Check Your Wishlist</a> 
                @endif
                <a href="{{ route('shop.index') }}" class="button button-dark">Continue Shopping</a> 
            </div>
         @endif
    </div>
</div>
@endsection

@section('extra-footer')
    <script>
        (function(){
          const qtySelectors = document.querySelectorAll('.quantity')
          Array.from(qtySelectors).forEach(function(element){
             element.addEventListener('change', function(){
                 //get item id
                 const id = element.getAttribute('data-id');
                 const product_id = element.getAttribute('data-product');
                 
                 // Send ajax request via axios
                 axios.patch(`/cart/${id}`, {
                     quantity: this.value,
                     product: product_id
                 })
                 .then(function(response){
                     //refresh the page
                     window.location.href = "{{ route('cart.index') }}"
                 })
                 .catch(function(error){
                     window.location.href = "{{ route('cart.index') }}"
                 });
             })
          });
          $('[data-toggle="tooltip"]').tooltip();
        })();
    </script>
@endsection