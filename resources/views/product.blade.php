@extends('layouts.app')

@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('landingpage')}}">Home</a>
    <span>></span>
    <a href="{{route('shop.index')}}">Shop</a>
    <span>></span>
    <a href="">Product</a>
</div>
</div>  
<!--End Breadcrumbs-->      
<!--Featured Section-->        
    <div class="featured-section">
        <div class="container-narrow single-product-container">
            <!--Single Product container-->
            @if(count($productImages) > 0)
            <div class="slider-holder">
            <div class="product-slider">
               @foreach($productImages as $image)
               <div class="">
                    <img src="{{ asset('/img/products/'.$image->path)}}" alt="product">
               </div>
               @endforeach
            </div>
            <div class="product-nav-slider">
                    @foreach($productImages as $image)
                    <div class="">
                         <img src="{{ asset('/img/products/'.$image->path)}}" alt="product">
                    </div>
                    @endforeach
            </div> 
            </div>  
            @else
              <div class="single-product-img">
               <img src="{{ asset($product->featuredImage())}}" alt="product">
              </div>
           @endif
           <div class="single-product-data">
           <h1 class="product-name">{{$product->name}}</h1>
               <div class="product-details">{{$product->brand->name}} | {{$product->details}}</div>
               <div class="separator"></div>
               <div class="product-rating">
               @if(count($product->reviews) > 0)
               <span class="text-uppercase">Rating:</span> {!! displayStars($product->getRating())!!}
               @else 
               <span class="text-uppercase">Rating:</span> N/A
               @endif
              </div>
               <div class="mini-header">More Details</div>            
               <div class="product-description">
                    {{$product->description}}
                </div>
                <div class="availability">{!! $productAvailability !!}</div>
                <div class="product-price">{{$product->displayPrice()}}</div>

                @if($product->availability > 0)
                <form action="{{route('cart.store')}}" method="POST" class="d-inline">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <input type="hidden" name="name" value="{{$product->name}}">
                    <input type="hidden" name="price" value="{{$product->price}}">
                    <button type="submit" class="button button-dark">Add To Cart</button>
                </form>
                @endif 
                @if(auth()->user() && !$inCart)
                <!-- ADD ITEM TO WISHLIST-->
                <form action="{{route('user.wishlist.add', $product->id)}}" method="POST" class="d-inline ml-1">
                  {{ csrf_field() }}
                  <button type="submit" class="button-gray text-uppercase"><i class="fi fi-heart-line mr-1"></i> Add To Wishlist</button>
                </form>
                @endif 
           </div>
            <!--End of products container-->
        </div> 
        <!--end container-->
        <div class="container-narrow">
          <div class="separator"></div>
          <div class="d-flex mb-4 align-items-end">
            <span  class="mini-header">Product Reviews <i class=" fi fi-forward-all-arrow mini-icon"></i> {{count($product->reviews)}}</span>
            @if(count($product->reviews) > 0)
               <div class="ml-5"><a href="#" class="btn-dark-border-sm show-reviews">Show Reviews <i class="fas fa-chevron-down ml-1"></i></a></div>
            @endif
          </div>
          @if(count($product->reviews) > 0)
            <div class="review-holder hide">
            @foreach($product->reviews as $review)
               <div class="review">
                 <div class="mb-1">{!!displayStars($review->rating)!!}</div>
                 <div class="mb-2">Review By: {{$review->user->name}} |  {{formatDate($review->created_at)}}</div>
                 <div>{{$review->review}}</div>
               </div>
               <div class="mini-separator"></div>
            @endforeach
          </div>
          @else 
          <div class="no-items mb-3">This product does not have any reviews yet.</div>
          @endif
        </div>
    </div>
<!--End Featured Section--> 

<!--Suggested Products Section-->
@include('partials.suggested-products')
<!--End Suggested Products Section-->   
@endsection

@section('extra-footer')
<script>
//Product Slider
$(document).ready(function(){
$('.product-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    asNavFor: '.product-nav-slider'
  });
 $('.product-nav-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.product-slider',
    arrows: false,
    focusOnSelect: true
  }); 

  //Suggested Products Slider
  $('.suggested-items').slick({
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 4,
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
    //show product reviews
    let showBtn = $('.show-reviews');
    let showArea = $('.review-holder');
    $(showBtn).on('click', (e)=>{
      e.preventDefault();
      $(showArea).slideToggle(300, ()=>{
        let elem = showArea.get(0);
        if(elem.style.display == 'block'){
          showBtn.get(0).innerHTML = 'Hide Reviews <i class="fas fa-chevron-up"></i></a>';
        }else{
          showBtn.get(0).innerHTML = 'Show Reviews <i class="fas fa-chevron-down"></i></a>';
        }
      });
    });
});
  </script>
@endsection
