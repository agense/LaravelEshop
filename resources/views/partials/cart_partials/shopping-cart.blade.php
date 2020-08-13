    <!--Order Details-->

        <div class="checkout-table p-4">
            <!--Checkout Table Row-->
            <div class="checkout-table-row checkout-table-heading">
                <div class="checkout-table-row-left">
                    <span></span>
                </div>
                <div class="checkout-table-row-right text-right">
                    <div>Quantity</div>
                    <div>Item Price</div>
                    <div>Item Total</div>
                </div>
            </div>    
            @foreach($cart->content() as $item)
            <div class="checkout-table-row pb-2">
                <div class="checkout-table-row-left">
                    @include('partials.product_partials.product-in-table')
                    
                    @if(isset($cartView) && $cartView = true)
                        <!--Cart actions for shopping cart-->
                        <div class="cart-table-actions">
                            <!-- REMOVE ITEM FROM CART-->
                            @include('partials.forms.cart_forms.remove-from-cart-form')
                            <!--MOVE ITEM TO WISHLIST-->
                            @include('partials.forms.cart_forms.move-from-cart-to-wishlist-form')
                        </div>
                    @else
                    <div></div>
                    @endif
                </div>

                <div class="checkout-table-row-right text-right">
                @if(isset($cartView) && $cartView = true)
                    <!--Modifiable quantity for shopping cart-->
                    <div class="cart-product-quantity">
                        @if($item->model->availability > 0)    
                        <select name="quantity" id="quantity" class="quantity" data-url="{{route('cart.update', $item->rowId)}}" data-product="{{$item->model->id}}">
                            @for($i =1; $i < $item->model->availability + 1; $i++)
                            <option {{ $item->qty == $i ? "selected" : '' }}>{{$i}}</option>
                            @endfor
                        </select>
                        @else
                        <span class="badge badge-danger">Sold Out</span>
                        @endif   
                    </div>
                @else
                    <!--Static quantity for checkout cart-->
                    <div>
                        <span class="mbtext">Quantity</span>
                        <span>{{$item->qty}}</span>
                    </div>
                @endif
                <div>
                    <span class="mbtext">Item Price</span>
                    <span>{{formatMoney($item->model->price)}}</span>
                </div>
                <div>
                    <span class="mbtext">Item Total</span>
                    <span>{{ formatMoney($item->model->price * $item->qty)}}</span>
                </div>
                </div>
            </div>
            @endforeach
            <!--End Checkout Table Row-->
        </div>
            @include('partials.cart_partials.cart-totals', ['totals' => $totals, 'cartView' => isset($cartView) ? $cartView : null]) 
    <!--End Order Details-->