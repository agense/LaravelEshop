    <!--Single Product container-->
    @if(count($product->images) > 0)
    <div class="slider-holder">
    <div class="product-slider">
        @foreach($product->images as $image)
        <div class="">
            <img src="{{ asset($image->image_link)}}" alt="product">
        </div>
        @endforeach
    </div>
    <div class="product-nav-slider">
            @foreach($product->images as $image)
            <div class="">
                    <img src="{{ asset($image->image_link)}}" alt="product">
            </div>
            @endforeach
    </div> 
    </div>  
    @else
        <div class="single-product-img">
        <img src="{{ asset($product->featured_image_link)}}" alt="product">
        </div>
    @endif