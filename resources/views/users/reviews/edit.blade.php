@extends('layouts.app')
@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                <div class="panel">
                    <div class="panel-body">
                    <div class="reviewed-product">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="cart-table-img mr-4">
                                <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
                            </div> 
                            <div class="cart-item-details">
                                <div class="cart-table-details"><a href="{{route('shop.show', $product->slug )}}">{{$product->brand->name}} | {{$product->name}}</a></div>
                                <div>{{$product->details}}</div>
                        </div>
                    </div> 
                    <div class="separator"></div>
                    <h1>Edit Product Review</h1>
                    </div>
                        <form action="{{route('user.reviews.update',[$review->id, $product->id])}}" method="POST">     
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group {{ $errors->has('rating') ? ' has-error' : '' }}">
                                    <label for="rating">Star Rating</label>
                                    <select name="rating" id="rating" class="form-control">
                                      <option value="5" {{$review->rating == 5 ? 'selected' : ''}}>5</option>
                                      <option value="4" {{$review->rating == 4 ? 'selected' : ''}}>4</option>
                                      <option value="3" {{$review->rating == 3 ? 'selected' : ''}}>3</option>
                                      <option value="2" {{$review->rating == 2 ? 'selected' : ''}}>2</option>
                                      <option value="1" {{$review->rating == 1 ? 'selected' : ''}}>1</option>
                                    </select>
                                    @if ($errors->has('rating'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rating') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('review') ? ' has-error' : '' }}">
                                    <label for="review">Your Review</label>
                                <textarea name="review" id="review" rows="4" class="form-control">{{old('review') ?? $review->review}}</textarea>
                                    @if ($errors->has('review'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('review') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="text-right mt-2 mb-5">
                                <button type="submit" class="button-primary-md">Save Changes</button>
                                </div>
                            </form>    
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
