@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Product Feature Types</h1>
@endsection

@section('content')
  @component('components.admin.button-header')
    @include('partials.admin_partials.buttons.new-item-btn',['modal' => true,'target' => 'featureFormModal'])
  @endcomponent

@if(count($features) > 0)
  @include('partials.admin_partials.index_tables.product-features-table')
@else 
<div class="no-items">There are no product features.</div>
@endif 

<!--Modals-->
@include('partials.modals.form-modal', ['type' => 'feature'])
@include('partials.modals.feature-options-modal')
@endsection

@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('featureFormModal','feature-form', "{{route('admin.features.index')}}");
})();
</script>
<script src="{{ asset('js/admin/features.options.js')}}"></script>
@endsection
