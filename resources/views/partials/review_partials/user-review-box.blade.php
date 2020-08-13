<div class="card border-secondary mb-4">
    @include('partials.review_partials.product-display')
    <div class="card-body">
        <div class="review-box">
            @if($product->reviews->count() > 0)                                 
                @foreach($product->reviews as $review)
                <div class="d-flex align-items-center justify-content-between">
                <div class="text-uppercase mr-2">My Rating: 
                    @include('partials.review_partials.star-rating', ['rating' => $review->rating])
                </div>
                    <a href="#" class="btn-sm btn-sm-orange opn-show" data-id="{{$review->id}}">Show Review <i class="fas fa-chevron-down ml-1"></i></a>
                </div>
                <div class="review-content-holder mt-3 {{ $errors->any() ? '': 'hide'}}" id="review_{{$review->id}}">
                    <div class="review-display">
                        <div class="text-right mb-3">
                            <button class="btn-sm btn-dark-border-sm edit-btn"><i class=" fi fi-pencil"></i></a></button>
                            @include('partials.forms.user-review-delete-form')
                        </div>
                        <div class="review-content">{{$review->review}}</div>
                    </div>
                    <div class="review-form {{ $errors->any() ? '': 'hide'}}">
                        @include('partials.forms.review-form', ['review' => $review])
                    </div>
                </div>
                @endforeach
            @else 
            <div class="d-flex align-items-center justify-content-between">
                <div>You have not yet reviewed this product.</div>
                <div><a href="#" class="btn-sm btn-dark-border-sm opn-create" data-id="{{$product->id}}">Review Now <i class="fas fa-chevron-down ml-1"></i></a></div>
            </div>
            <div class="review-content-holder hide mt-3" id="product_{{$product->id}}">
                <div class="review-form">
                    @include('partials.forms.review-form', ['review' => null])   
            </div>
            </div>
            @endif
        </div>
    </div>
</div>