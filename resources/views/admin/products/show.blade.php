@extends('layouts.admin')
@section('content')
<div class="mb-5 single-product-container">
    <div class="single-product-data">
        <h1>{{$product->name}}</h1>
        <div class="separator"></div>
        <div class="product-data">
                <div>Brand: {{strtoupper($product->brand->name)}}</div>
                <div>Price: {{$product->displayPrice()}}</div>
                <div>Availability: {{$product->availability}}</div>
                <div>Categories: 
                    @foreach($product->categories as $category)
                    {{$category->name}}
                    @endforeach
                </div>
                <div>Featured: {{$product->featured == 0 ? "No" : "Yes"}}</div>
        </div>

        <div class="product-details">
                <div class="mini-header">Details</div>
                {{$product->details}}
        </div>
        <div>
            <div class="mini-header">Description</div>
            {{$product->description}}
        </div>
    </div>
    <!--Single Product container-->
    @if(count($productImages) > 0)
    <div class="slider-holder">
    <div class="product-slider">
       @foreach($productImages as $image)
       <div class="">
            <img src="{{ asset('/img/products/'.$image->path)}}" alt="{{$product->name}}">
       </div>
       @endforeach
    </div>
    <div class="product-nav-slider">
            @foreach($productImages as $image)
            <div class="">
                 <img src="{{ asset('/img/products/'.$image->path)}}" alt="{{$product->name}}">
            </div>
            @endforeach
    </div> 
    </div>  
    @else
      <div class="single-product-img">
       <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
      </div>
   @endif
</div>
<div class="actions">
<div><a href="{{route('products.index')}}" class="btn btn-primary">Back</a></div>
<div>
@can('isAdmin')
<a href="{{route('products.edit', $product->id)}}" class="btn btn-success">Edit</a>
<form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-primary" onclick="return confirm('Delete this product?')">Delete</button>
</form>
@endcan
</div>
</div>
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
    focusOnSelect: true
  }); 
});
  </script>
@endsection