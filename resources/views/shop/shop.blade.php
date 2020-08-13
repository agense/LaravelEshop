@extends('layouts.app')
@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('pages.landing')}}">Home</a>
    <span>></span>
    <a href="{{route('pages.shop.index')}}">Shop</a>
</div>
</div>        
<!--Featured Section-->        
    <div class="featured-section">
        <div class="container-narrow filters-container">
            <div class="shop-filters"> 
                @include('partials.product_partials.shop-filters')
            </div>    

            <!--Products container-->
            <div class="content">
            <!--Products Header-->    
            <div class="products-header">
                <div class="products-heading">
                <h2>{{ $searchTitle }} </h2> 
                <span class="count ml-3 badge badge-rounded"> {{ $products->productCount }} 
                    {{($products->productCount == 1) ? "Product" : "Products" }}
                </span>
                </div>
                <div class=sort-container>
                    @include('partials.forms.filter_forms.shop-sort')
                </div>
            </div>
            <!--End of products header-->

            <div class="separator"></div>
                @if(count($products) > 0)
                <div class="products-container text-center full-display">
                    @foreach($products as $product)
                    <!--Single Product-->
                    <div class="product">
                        <div class="product-img">
                        <a href="{{route('pages.shop.show', $product->slug)}}">
                            <img src="{{ asset($product->featured_image_link)}}" alt="product">
                        </a>
                        </div>
                        <div class="product-copy">
                        <a href="{{route('pages.shop.show', $product->slug)}}">
                            <span class="product-name">{{$product->brand->name}} | {{$product->name}}</span>
                        </a>
                        <div class="product-price">{{$product->displayPrice()}}</div>
                        </div>
                    </div>
                    @endforeach 
                </div>
                @else 
                <div class="md-header text-center py-5">There are no products matching your filters.</div>  
                @endif 
            
            <!--Pagination-->
            <div class="mt-5">
                   @if($products->count() > 0)
                   {{ $products->appends(request()->input())->links() }}
                   @endif
            </div>
            <!--End Pagination-->
            </div>
            <!--End of products container-->
        </div><!--end container-->
    </div>
<!--End Featured Section--> 
@endsection

@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/scripts/togglers.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/shop.filters.js') }}"></script>
<script>
$(document).ready(function(){   
    initTogglers('cat-filter', 'cat-filter-holder');
    initTogglers('all-filters', 'all-filters-holder');
    initFilterTogglers('shop-filter-link');
});
  </script>
@endsection
