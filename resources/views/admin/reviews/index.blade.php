@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Reviews</h1>
@endsection

@section('content')
  @component('components.admin.button-header', ['flex' => true, 'addClass' => 'flex-row-reverse']) 
    <div class="btn-block-right btns-split">
      @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.reviews.deleted', 'text' => 'Deleted Reviews'])
    </div>
    <!--Search-->
    @include('partials.forms.filter_forms.search-form', [
      'targetUrl' => 'admin.reviews.index',
      'text'=> 'Search by product or customer name...'
      ])
    <!--End Search-->
  @endcomponent

  <!--Clear Filters-->
  @if(!empty($filters))
  <div class="text-left pb-1">
      <a href="{{route('admin.reviews.index')}}" class="filter-remover">
          <i class="fas fa-times mr-1"></i>Clear All Filters
      </a>
  </div>
  @endif
 <!--End Clear Filters-->

  @if(count($reviews) > 0)
    @include('partials.admin_partials.index_tables.reviews-table')
    <div class="mt-5">
      {{ $reviews->appends(request()->input())->links() }}
    </div>
    <!-- Modal -->
    @include('partials.modals.review-show-modal')
    <!--EndModal-->    
  @else 
    <div class="no-items">No reviews found.</div>
  @endif           
@endsection

@section('extra-footer')
  <script type="text/javascript" src="{{ asset('js/admin/review.display.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/admin/sorters.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/admin/filters.js') }}"></script>
@endsection