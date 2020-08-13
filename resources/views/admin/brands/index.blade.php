@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Brands</h1>
@endsection

@section('content')

@component('components.admin.button-header')
  @can('isAdmin')
    @include('partials.admin_partials.buttons.new-item-btn',['modal' => true,'target' => 'brandFormModal'])
  @endcan
@endcomponent

@if(count($brands) > 0)
@include('partials.admin_partials.index_tables.brands-table')
    
<div class="mt-5">
  {{ $brands->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no brands.</div>
@endif 

<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'brand'])
@endsection

@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('brandFormModal','brand-form', "{{route('admin.brands.index')}}" );
})();
</script>
@endsection