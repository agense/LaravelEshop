<div class="container-tabs">
    <ul class="nav nav-pills">
        <li><a data-toggle="pill" href="#description" class="active">Description</a></li>
        <li><a data-toggle="pill" href="#specs">Details</a></li>
        <li><a data-toggle="pill" href="#reviews">Reviews({{$product->review_count}}) </a></li>
      </ul>
      <div class="tab-content mb-4">
        <!--Details Tab-->
        <div id="description" class="tab-pane fade in active show">
            <div class="tab-content-holder">
                <div class="summernote-content">{!!$product->description!!}</div>
            </div>
        </div>
        <!--Details Tab-->
        <div id="specs" class="tab-pane fade">
            <div class="tab-content-holder">
                <div class="product-feature-holder">
                    @if(count($product->feature_list) > 0)
                        @foreach ($product->feature_list as $name => $value)
                        <div class="details-section">
                            <span class="product-feature-title">{{$name}}</span>
                            <span>{{$value}}</span>
                        </div>
                        @endforeach
                    @else 
                    <div class="text-center">There are no specifications for this product.</div>
                    @endif
                </div>
            </div>
        </div>
        <!--Reviews Tab-->
        <div id="reviews" class="tab-pane fade">
            <div class="tab-content-holder">
                  @if(count($product->reviews) > 0)
                    <div class="review-holder">
                    @foreach($product->reviews as $review)
                        @include('partials.review_partials.review-display')
                    @endforeach
                  </div>
                  @else 
                  <div class="text-center mb-3">This product does not have any reviews yet.</div>
                  @endif
            </div>
        </div>
      </div>
  </div>