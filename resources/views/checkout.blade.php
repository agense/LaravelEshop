@extends('layouts.app')

@section('content')
<div class="container container-narrow">
    <h1 class="left-heading">Checkout</h1>
    <div class="separator"></div> 
        <!-- Messages-->
        @if(session()->has('success_message'))
        <div class="alert alert-success">
            {{session()->get('success_message')}}
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
    <!--End messages-->
    <div class="ckeckout-section">
        <!--Customer Details-->
        <div>
          <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
              {{ csrf_field() }}
              <h2>Billing Details</h2>
              <div class="form-group">
              <label for="email">Email Address</label>
              @if(auth()->user())
              <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
              @else 
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
              @endif 
              </div>
              <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
              </div>
              <div class="form-group">
                    <label for="address">Address</label>
                    <input type="address" class="form-control" id="address" name="address" value="{{ old('address') }}">
              </div>
              <div class="half-form">
                    <div class="form-group">
                            <label for="city">City</label>
                            <input type="city" class="form-control" id="city" name="city" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                            <label for="region">Region</label>
                            <input type="region" class="form-control" id="region" name="region" value="{{ old('region') }}">
                    </div>
              </div>
              <div class="half-form">
                    <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="postalcode" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}">
                    </div>
                    <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
              </div>
              <!--Payment Details-->
              <h2>Payment Details</h2>
              <p>Payment must be made in cash upon item receipt</p>
              <p class="alert alert-danger">
                !!! Note, this is a development application, all data is fake and no real orders can be made.
              </p>
              <!--End Payment Details-->
              <div class="text-right">
                  <button type="submit" class="button-primary" id="complete-order">Complete Order</button>
              </div>
            </form>
        </div>
        <!--End Customer Details-->
        <!--Product Details-->
        <div class="checkout-table-container">
            <h2>Your Order</h2>
            <div class="checkout-table">
                <!--Checkout Table Row-->
                @foreach(Cart::instance('default')->content() as $item)
                <div class="checkout-table-row">
                    <div class="checkout-table-row-left">
                        <div class="checkout-img-holder">
                            <img src="{{asset('/img/products/'.$item->model->featured_image)}}" alt="product" class="checkout-table-img">
                        </div>
                        <div class="checkout-item-details">
                            <div class="checkout-table-item">{{$item->model->brand->name}} | {{$item->model->name}}</div>
                            <div class="checkout-table-description">{{$item->model->details}}</div>
                            <div class="checkout-table-price">{{$item->model->displayPrice()}}</div>
                        </div>
                    </div>
                    <div class="checkout-table-row-right">
                    <div class="checkout-table-quantity">{{$item->qty}}</div>
                    </div>
                </div>
                @endforeach
                <!--End Checkout Table Row-->
            </div>
            <div class="checkout-totals mt-3">
                <div class="checkout-totals-left">
                    <div>Subtotal</div>
                    <!--Discount Section-->
                    @if(session()->has('coupon'))
                    <div>Discount ({{ session()->get('coupon')['name'] }} | {{session()->get('coupon')['display_value']}})
                      <!--Remove Discount-->
                      <form action="{{ route('coupon.destroy') }}" method="POST" class="inline-form">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" class="inline-link">Remove</button>
                      </form>
                      <div>New Subtotal:</div>
                  </div>
                  <!--End Discount Section-->
                    @endif
                    <div>Tax</div>
                    <div class="checkout-totals-total">Total</div>
                </div>
                <div class="checkout-totals-right">
                        <div>{{ displayPrice(Cart::instance('default')->subtotal()) }}</div>

                        <!--Discount Section-->
                        @if(session()->has('coupon'))
                        <div>-{{ displayPrice($discount) }}</div>
                        <div>{{ displayPrice($newSubtotal) }}</div>
                        @endif
                        <!--End Discount Section-->
                        <div>{{ displayPrice($newTax) }}</div>
                        <div class="checkout-totals-total">{{ displayPrice($newTotal) }}</div>
                </div>
            </div>
        <br />    
         <!--code section-->
         @if(!session()->has('coupon'))
        <span class="have-code">Discount Number:</span><br/>
        <div class="have-code-container">
            <form action="{{ route('coupon.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="coupon_code" id="coupon_code">
                <button type="submit" class="button button-dark">Apply</button>
            </form>
        </div>
        @endif
        <!--end code section-->
        </div>
        <!--End Product Details-->
    </div>
</div>
@endsection