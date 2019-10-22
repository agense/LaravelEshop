@extends('layouts.app')

@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('landingpage')}}">Home</a>
    <span>></span>
    <a href="{{route('shop.index')}}">Shop</a>
</div>
</div>        
<!--Featured Section-->        
    <div class="featured-section">
            <div class="container-narrow filters-container">
            <div> 
                <h3 class="mini-header filters-header">Filter By</h3>
                <div class="filters">
                <div class="single-filter">
                    <a href="#" class="filter-link"  id="cat-filter">Categories <i class="fas fa-chevron-down"></i></a>
                    <div class="f-list" id="cat-holder">
                        <ul class="filter-list">
                            @foreach($categories as $category)
                            <li class="filter-list-item {{ setActiveCategory($category->slug) }}">   
                                {{--Attaching a query string to url--}}
                                <a href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                {{ $category->name }} 
                                <span class="counter"> ({{$category->products->count()}}) </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="single-filter">
                <a href="#" class="filter-link"  id="brand-filter">Brands <i class="fas fa-chevron-down"></i></a>
                <div class="f-list" id="brand-holder">
                <ul class="filter-list">
                        @foreach($brands as $brand)
                          <li class="filter-list-item">   
                              {{--Attaching a query string to url--}}
                              <a href="{{ route('shop.index', ['category' => request()->category, 'brand' => $brand->id]) }}">
                                {{ $brand->name }}
                                <span class="counter"> ({{$brand->products->count()}}) </span>
                            </a>
                          </li>
                        @endforeach
                    </ul>
                </div> 
                </div> 
                </div>  
            </div>    

            <!--Products container-->
            <div class="content">
            <!--Products Header-->    
            <div class="products-header">
                <div class="products-heading">
                <h2>{{ $categoryName }} {{ ($brandName != "") ? '| '.$brandName : "" }} </h2> 
                <span class="count ml-3 badge badge-black"> {{ $productCount}} Products</span>
                </div>
                <div class=sort-container>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle border-btn" type="button" id="sortListBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Sort</span>
                        <span><i class="fas fa-chevron-down"></i></span>
                        </button>
                            <div class="dropdown-menu" aria-labelledby="sortListBtn">
                                <a href="{{ route('shop.index', ['category' => request()->category, 'brand' => request()->brand, 'sort' => 'low_high']) }}" class="sort-list-item">
                                           Price (Low to High)</a>
                                <a href="{{ route('shop.index', ['category' => request()->category, 'brand' => request()->brand, 'sort' => 'high_low']) }}" class="sort-list-item">
                                            Price (High to Low)</a>
                            </div>
                    </div>    
                </div>
            </div>
            <!--End of products header-->
            <div class="separator"></div>
            <div class="products-container text-center">
                @forelse($products as $product)
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
                @empty 
                <div class="no-items">No items found.</div>    
                @endforelse
            </div>
            <!--Pagination-->
            <div class="mt-5">
                   {{ $products->appends(request()->input())->links() }}
            </div>
            <!--End Pagination-->
            </div>
            <!--End of products container-->
        </div><!--end container-->
    </div>
<!--End Featured Section--> 
@endsection

@section('extra-footer')
<script>
//Product Slider
$(document).ready(function(){   
    //show category list 
    let catLink = $('#cat-filter');
    let catArea = $('#cat-holder');
    $(catLink).on('click', (e)=>{
      e.preventDefault();
      $(catArea).slideToggle(300);
    });
    //show brand list 
    let brandLink = $('#brand-filter');
    let brandArea = $('#brand-holder');
    $(brandLink).on('click', (e)=>{
      e.preventDefault();
      $(brandArea).slideToggle(300);
    });
});
  </script>
@endsection
