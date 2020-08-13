<form action="" method="POST" class="rv-form" 
data-url={{$review !== null ? route('user.reviews.update', $review->id) : route('user.reviews.store', $product->id)}}
data-id="{{$review !== null ? $review->id : null}}">     
    {{ csrf_field() }}
    @if(isset($review))
    {{ method_field('PUT')}}
    @endif
    <div class="form-group">
        <label for="rating">Star Rating</label>
        <select name="rating" id="rating" class="form-control">
          @for($i=1; $i <=5; $i++)  
            <option value="{{$i}}" {{(($review !== null) && $review->rating == $i) ? 'selected="selected"' : ''}}>{{$i}}</option>
          @endfor
        </select>
    </div>

    <div class="form-group">
        <label for="review">Your Review</label>
        <textarea name="review" id="review" rows="4" class="form-control">
            {{($review !== null) ? $review->review : ''}}
        </textarea>
    </div>
    <div class="text-right mt-2">
    <button type="submit" class="button btn-sm btn-dark-sm">Save Review</button>
    </div>
</form> 