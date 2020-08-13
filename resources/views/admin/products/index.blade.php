@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Products</h1>
@endsection
@section('content')
@component('components.admin.button-header', ['flex' => true, 'addClass' => 'flex-row-reverse'])
  <div class="btn-block-right btns-split">
    @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.products.deleted', 'text' => 'Inactive Products'])
    @include('partials.admin_partials.buttons.new-item-btn',['target' => 'admin.products.create'])
  </div> 
  <div class="search-filter">
    <a class="btn-filter" data-toggle="collapse" href="#filter-collapse" 
    role="button" aria-expanded="false" aria-controls="filter-collapse">
      Filter <i class="fas fa-chevron-down"></i>
    </a>
    <!--Search-->
      @include('partials.forms.filter_forms.search-form', [
        'targetUrl' => 'admin.products.index',
        'text'=> 'Search by name...'
        ])
    <!--End Search-->
</div>
@endcomponent

<!--Filters-->
@include('partials.forms.filter_forms.products-filter-form', ['targetUrl' => 'admin.products.index'])
<!--End Filters -->

@if(count($products) > 0)
  @include('partials.admin_partials.index_tables.products-table')
 
<div class="mt-5">
  @if($products->count() > 0)
  {{ $products->appends(request()->input())->links() }}
  @endif
</div>
  <!-- Modal -->
  @include('partials.modals.products-update-quantity-modal')
  @else 
  <div class="no-items">No products were found.</div>
  @endif 
@endsection

@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/admin/filters.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/sorters.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/products.quantity.edit.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/featured.item.toggler.js') }}"></script>
@endsection