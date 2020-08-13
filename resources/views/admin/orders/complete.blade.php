@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Complete Orders</h1>
@endsection
@section('content')

@component('components.admin.button-header', ['flex' => true, 'addClass' => 'flex-row-reverse'])
  <div class="btn-block-right btns-split">
    @include('partials.admin_partials.buttons.direction-btn',
    ['routeUrl' => 'admin.orders.index', 'text' => 'Active Orders'])
  </div>
  <div class="search-filter">
      <a class="btn-filter" data-toggle="collapse" href="#filter-collapse" role="button" aria-expanded="false" aria-controls="filter-collapse">
        Filter <i class="fas fa-chevron-down"></i>
      </a>
    <!--Search-->
      @include('partials.forms.filter_forms.search-form', [
        'targetUrl' => 'admin.orders.complete',
        'text'=> 'Search by order nr. or customer name...'
        ])
    <!--End Search-->
</div>
@endcomponent

<!--Filters-->
@include('partials.forms.filter_forms.orders-filter-form', ['completeView' => true, 'targetUrl' => 'admin.orders.complete'])
<!--End Filters -->

@if(count($orders))
    @include('partials.admin_partials.index_tables.orders-table', ['completeView' => true])
<div class="mt-5">
  {{ $orders->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">No completed orders exist</div>
@endif 
@endsection
@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/admin/sorters.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/filters.js') }}"></script>
@endsection