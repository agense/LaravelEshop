@if(isset($rating))
<span class="star-rating">
    @for($i = 0; $i < $rating; $i++)
      <span><i class="fas fa-star star-complete"></i></span>
    @endfor
    @if(intval($rating) < 5)
      @for($i = 5; $i > intval($rating); $i--)
       <span><i class="far fa-star star-grey"></i></span>
      @endfor
    @endif
</span>
@else 
  @for($i = 1; $i <= 5; $i++)
    <span><i class="far fa-star star-grey"></i></span>
  @endfor
@endif


