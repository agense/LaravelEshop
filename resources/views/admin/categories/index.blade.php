@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Categories</h1>
@endsection

@section('content')

@component('components.admin.button-header')
  @can('isAdmin')
    @include('partials.admin_partials.buttons.new-item-btn',['modal' => true,'target' => 'categoryFormModal'])
  @endcan
@endcomponent

@if(count($categories) > 0)
  @include('partials.admin_partials.index_tables.categories-table')
  <div class="mt-5">
    {{ $categories->appends(request()->input())->links() }}
  </div>
@else 
<div class="no-items">There are no categories.</div>
@endif 
<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'category'])
@endsection

@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>

<script>
  (function(){
    initModal('categoryFormModal','category-form', "{{route('admin.categories.index')}}");
  })();
</script>
@endsection