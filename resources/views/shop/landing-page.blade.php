@extends('layouts.app')
@section('header')
            <!--Hero-->
            <header>
                @include('partials.landing-page-slider')
            </header>
            <!--End Hero-->
@endsection

@section('content')        
<!--Featured Section-->        
    <div class="featured-section">
            <div class="container">
                <h1 class="text-center lg-header">Top Products</h1>     
                <p class="section-description"></p>
            
            @foreach($categories as $category)
            <div class="row slide-row">
            <div class="col-lg-3 slider-text-col">
                <div class="slider-text">
               <h2 class="md-header text-center">{{$category->name}}</h2>
               <div class="mini-txt text-center">Showing {{$category->products->count()}} products from {{$category->products_count}}</div><br/>
               <div class="d-flex align-items-center justify-content-center mt-2 mb-3">
                 <span class="arrow-holder">
                 <span class="arrow-top"></span>
                 <span class="arrow-bottom"></span>
                 </span>
                 <span class="min-price-display">From {{formatMoney($category->min_price)}}</span>
                 <span class="arrow-right"></span>
               </div>
               <div><a href="{{route('pages.shop.index', ['category' => $category->slug])}}" class="btn-sm btn-dark-border-sm mt-3 w-100">All {{$category->name}}</a></div>
               </div>
              </div>
            <!--Products container-->
            <div class="col-lg-9 slider-slides-col">
                <div class="slider-holder">
                <div class="category-product-slider">
                @foreach($category->products as $product)
                <!--Single Product-->
                <div class="product">
                    <div class="product-img">
                    <a href="{{route('pages.shop.show', $product->slug)}}">
                    <img src="{{ asset($product->featured_image_link)}}" alt="product">
                    </a>
                    </div>
                    <div class="product-copy">
                    <a href="{{route('pages.shop.show', $product->slug)}}"><div class="product-name">{{$product->brand->name}} | {{$product->name}}</div></a>
                    <div class="product-price">{{$product->displayPrice()}}</div>
                    </div>
                </div>
                <!--End Single Product-->
                @endforeach
            </div>
            </div>
            </div>
        </div>
            @endforeach
            <!--End of products container-->
        </div>
    </div>
<!--End Featured Section--> 
@endsection

@section('extra-footer')
 <script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('js/scripts/sliders.js') }}"></script>
<script> 
$(document).ready(function(){  
  initFullSlider('hero-slider');
  initCarousel('category-product-slider')
});
  </script>
@endsection