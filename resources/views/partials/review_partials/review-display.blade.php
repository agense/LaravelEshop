<div class="review">
    <div class="mb-1"> @include('partials.review_partials.star-rating', ['rating' => $review->rating])</div>
    <div class="mb-2 reviewer">Review By: {{$review->user->name}} |  {{$review->created_at}}</div>
    <div>{{$review->review}}</div>
</div>
<div class="mini-separator"></div>