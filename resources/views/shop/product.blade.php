@extends('layouts.app')

@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('pages.landing')}}">Home</a>
    <span>></span>
    <a href="{{route('pages.shop.index')}}">Shop</a>
    <span>></span>
    <a href="">Product</a>
</div>
</div>  
<!--End Breadcrumbs-->      
<!--Featured Section-->        
    <div class="featured-section">
        <div class="container-narrow single-product-container">
          @include('partials.product_partials.product-images')
           <div class="single-product-data">
           <h1 class="product-name">{{$product->name}}</h1>
               <div class="product-details">{{$product->brand->name}}</div>
               <div class="separator"></div>
               <div class="product-rating">
               @if($product->review_count > 0)
               @include('partials.review_partials.star-rating', ['rating' => $product->getRating()])
               <small class="text-uppercase ml-2">
                 {{$product->review_count}} {{$product->review_count == 1 ? 'Review' : 'Reviews'}}
              </small>
               @else 
               @include('partials.review_partials.star-rating')
               <small class="text-uppercase ml-2">No Rating Yet</small> 
               @endif
              </div>
              <div class="product-price-section">
                <div class="product-price">{{$product->displayPrice()}}</div>
                <small>* 
                  @if($settings->tax_included) VAT included
                  @else An add on VAT of {{$settings->tax_rate}}% is applicable.
                  @endif
                </small>
              </div>
                <div class="availability">
                  @include('partials.product_partials.availability-badge', ['availability' => $product->availability])
                </div>
                <br/>
                @if($product->availability > 0)
                  @include('partials.forms.cart_forms.add-to-cart-form')
                @endif 
                  @include('partials.forms.cart_forms.add-to-wishlist-form')
           </div>
            <!--End of products container-->
        </div> 
        <!--end container-->
        <div class="container-narrow">
          <div class="separator"></div>
          @include('partials.product_partials.product-tabs')
        </div>
    </div>
<!--End Featured Section--> 

<!--Suggested Products Section-->
@include('partials.product_partials.suggested-products')
  
@endsection

@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/sliders.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/togglers.js') }}"></script>
<script>
//Product Slider
$(document).ready(function(){
  //Suggested Items Slider
  initCarousel('suggested-items', 4, 4);

  //Product Display Slider
  initNavigationSlider('product-nav-slider', 'product-slider');

});
  </script>
@endsection
