@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Reviews</h1>
@endsection

@section('content')
@if(count($reviews) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td>Product</td>
            <td>Brand</td>
            <td class="text-center">Star Rating</td>
            <td class="text-center">Customer</td>
            <td class="text-center">Review Date</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
          <td>{{$review->product->name}}</td>
          <td>{{$review->product->brand->name}}</td>
          <td class="text-center">{{$review->rating}}</td>
          <td class="text-center">{{$review->user->name}}</td>
          <td class="text-center">{{formatDate($review->created_at)}}</td>
          <td class="text-right">
              <button type="button" class="btn btn-warning btn-sm review-show" data-id="{{$review->id}}" data-toggle="modal" data-target="#reviewsModal"><i class="fi fi-eye"></i></button>
              @can('isAdmin')
              <form action="{{route('admin.review.delete', $review->id)}}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this review?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
              @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
<div class="mt-5">
  {{ $reviews->appends(request()->input())->links() }}
</div>
<!-- Modal -->
<div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="reviewsModalLabel">Review for: <span id="review-product"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="review-holder">
                <div>Rating: <span id="review-rating"></span></div>
                <div>Customer: <span id="review-customer"></span></div>
                <div id="review-content" class="mt-4"></div>
              </div>
            </div>
            <div class="modal-footer"></div>
          </div>
        </div>
      </div>
<!--EndModal-->    
@else 
<div class="no-items">There are no reviews yet.</div>
@endif           
@endsection
@section('extra-footer')
<script>
(function(){ 
  $('#reviewsModal').on('show.bs.modal', function (e) {
  let targetReview = e.relatedTarget;
  let review = targetReview.getAttribute('data-id');

  axios.get(`/admin/reviews/${review}`)
  .then(function(response){
     $('#review-product').html(response.data.brand+ ' | '+response.data.product);
     $('#review-customer').html(response.data.user);
     $('#review-rating').html(displayStars(response.data.rating));
     $('#review-content').html(response.data.review);
  })
  .catch(function (error) {
    toastr.error('There was an error.');
  });
})
function displayStars(rating){
  let stars = '<span class="star-rating">';
  for(i = 1; i <= rating; i++){
    stars += '<span><i class="fi fi-star-full"></i></span>';
  }
  stars += '</span>';
  return stars;
}
})();
</script>
@endsection