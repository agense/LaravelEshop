@extends('layouts.app')

@section('header')
            <!--Hero-->
            <header>
            <div class="hero-slider">
            <div class="hero">
                <div class="hero-slide">
                <div class="hero-copy">
                    <h1>{{$settings->first_slide_title ?? $settings->site_name}}</h1>
                    <p>{{$settings->first_slide_subtitle}}</p>
                    <div class="hero-buttons">
                        @if($settings->first_slide_btn_link)
                        <a href="{{$settings->first_slide_btn_link}}" class="button button-white">{{$settings->first_slide_btn_text}}</a>
                        @endif
                      </div>
                </div>
                <div class="hero-image"><img src="img/hero-photo.jpg" alt="hero image"></div>
                </div>
            </div>
            <div class="hero">
                <div class="hero-slide">
                    <div class="hero-image"><img src="img/hero-slide-2.png" alt="hero image"></div>
                    <div class="hero-copy">
                        <h1>{{$settings->second_slide_title ?? $settings->site_name}}</h1>
                        <p>{{$settings->second_slide_subtitle}}</p>
                        <div class="hero-buttons">
                            @if($settings->second_slide_btn_link)
                            <a href="{{$settings->second_slide_btn_link}}" class="button button-white">{{$settings->second_slide_btn_text}}</a>
                            @endif
                          </div>
                    </div>
                </div>
                </div>
            </div>    
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
                 <span class="min-price-display">From {{displayPrice($category->min_price)}}</span>
                 <span class="arrow-right"></span>
               </div>
               <div><a href="{{route('shop.index', ['category' => $category->slug])}}" class="btn-dark-border-sm mt-3 w-100">All {{$category->name}}</a></div>
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
                    <a href="{{route('shop.show', $product->slug)}}">
                    <img src="{{ asset($product->featuredImage())}}" alt="product">
                    </a>
                    </div>
                    <div class="product-copy">
                    <a href="{{route('shop.show', $product->slug)}}"><div class="product-name">{{$product->brand->name}} | {{$product->name}}</div></a>
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
<script> 
  //Suggested Products Slider
$(document).ready(function(){  
  $('.hero-slider').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows:false,
  autoplay: true,
  autoplaySpeed: 3000,
});
$('.category-product-slider').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows:true,
  responsive: [
    {
      breakpoint: 996,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
] 
});
});
  </script>
@endsection