@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1>Review Products</h1>
                <hr/>
                <div class="panel-body">
                    @if(count($products) > 0)
                    <div class="md-header mb-3">Ordered Products</div>   
                    @foreach($products as $product)
                    <div class="card border-secondary mb-4">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-center">
                                <div class="cart-table-img mr-4">
                                    <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                                </div> 
                                <div class="cart-item-details">
                                    <div class="cart-table-details">
                                        <a href="{{route('shop.show', $product->slug )}}">
                                        {{$product->brand->name}} | {{$product->name}}
                                    </a>
                                    </div>
                                    <div>{{$product->details}}</div>
                                </div>
                                </div> 
                            </div>
                            <div class="card-body">
                                <div class="review-box">
                                    @if($product->reviews->count() > 0)                                 
                                      @foreach($product->reviews as $review)
                                      <div class="d-flex align-items-center justify-content-between">
                                      <div class="text-uppercase mr-2">My Rating: {!!displayStars($review->rating)!!}</div>
                                      <a href="#" class="btn-sm-orange opn-show" data-id="{{$review->id}}">Show Review <i class="fas fa-chevron-down ml-1"></i></a>
                                      </div>
                                        <div class="review-content-holder hide mt-3" id="review_{{$review->id}}">
                                          <div class="text-right mb-3">
                                                <a href="{{route('user.reviews.edit', [$review->id, $product->id])}}" class="btn-dark-border-sm"><i class=" fi fi-pencil"></i></a>
                                                <form action="{{ route('user.reviews.delete', $review->id) }}" method="POST" class="d-inline">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}<!--Change method from post to delete-->
                                                        <button type="submit" class="btn-dark-sm" onclick="return confirm('Delete this review?')"><i class="fi fi-recycle-bin-line"></i></button>
                                                </form>
                                            </div>
                                           <div>{{$review->review}}</div>
                                        </div>
                                      @endforeach
                                    @else 
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="no-items">You have not yet reviewed this product.</div>
                                        <div><a href="#" class="btn-dark-border-sm opn-create" data-id="{{$product->id}}">Review Now <i class="fas fa-chevron-down ml-1"></i></a></div>
                                    </div>
                                    <div class="review-content-holder hide mt-3" id="product_{{$product->id}}">
                                        <div class="review-form">
                                        <form action="{{route('user.reviews.store', $product->id)}}" method="POST">     
                                            {{ csrf_field() }}
                                            <div class="form-group {{ $errors->has('rating') ? ' has-error' : '' }}">
                                                <label for="rating">Star Rating</label>
                                                <select name="rating" id="rating" class="form-control">
                                                  <option value="5">5</option>
                                                  <option value="4">4</option>
                                                  <option value="3">3</option>
                                                  <option value="2">2</option>
                                                  <option value="1">1</option>
                                                </select>
                                                @if ($errors->has('rating'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('rating') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('review') ? ' has-error' : '' }}">
                                                <label for="review">Your Review</label>
                                                <textarea name="review" id="review" rows="4" class="form-control"></textarea>
                                                @if ($errors->has('review'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('review') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="text-right mt-2">
                                            <button type="submit" class="button-primary-md">Save Review</button>
                                            </div>
                                        </form>    
                                    </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                    @endforeach
                    <div class="mt-5">
                            {{$products->appends(request()->input())->links()}}
                    </div> 
                    @else
                    <div class="md-header mb-3">There are no products in your order list yet</div>
                    <span>You can only review products you have purchased.</span>   
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-footer')
<script>
$(document).ready(function(){
    let openBtns = $('.opn-show');
    let createBtns = $('.opn-create');
    
    //show product reviews
    $(openBtns).each(function(index, element){
        $(element).on('click', function(e){
            e.preventDefault();
            let targetId = $(e.target).attr('data-id');
            let targetDiv = 'review_'+targetId;
            let targ = $('#'+targetDiv).get( 0 );
            $(targ).slideToggle(300, function(){
                if(targ.style.display == 'block'){
                   e.target.innerHTML = 'Hide Review <i class="fas fa-chevron-up ml-1"></i></a>';
                }else{
                   e.target.innerHTML = 'Show Review <i class="fas fa-chevron-down ml-1"></i></a>';
                }
            });
        })
    });

    //show add new review form
    $(createBtns).each(function(index, element){
        $(element).on('click', function(e){
            e.preventDefault();
            let productId = $(e.target).attr('data-id');
            let productDiv = 'product_'+productId;
            let targetProduct = $('#'+productDiv).get( 0 );
            $(targetProduct).slideToggle(300); 
        })
    });
});
</script>
@endsection