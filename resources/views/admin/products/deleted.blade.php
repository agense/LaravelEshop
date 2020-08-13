@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Inactive Products</h1>
@endsection
@section('content')
@component('components.admin.button-header', ['flex' => true, 'addClass' => 'flex-row-reverse'])
  @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.products.index', 'text' => 'Active Products'])
  <div class="search-filter">
    <a class="btn-filter" data-toggle="collapse" href="#filter-collapse" role="button" aria-expanded="false" aria-controls="filter-collapse">
      Filter <i class="fas fa-chevron-down"></i>
    </a>
    <!--Search-->
      @include('partials.forms.filter_forms.search-form', [
        'targetUrl' => 'admin.products.deleted',
        'text'=> 'Search by name...'
        ])
    <!--End Search-->
  </div>
@endcomponent

<!--Filters-->
@include('partials.forms.filter_forms.products-filter-form', ['targetUrl' => 'admin.products.deleted'])
<!--End Filters -->
 
@if(count($products) > 0)
@include('partials.admin_partials.index_tables.products-table', ['deletedView' => true])

<div class="mt-5">
  {{ $products->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no deleted products.</div>
@endif 
@endsection

@section('extra-footer')
  <script type="text/javascript" src="{{ asset('js/admin/filters.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/admin/sorters.js') }}"></script>
@endsection