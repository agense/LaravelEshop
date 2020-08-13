@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Administrators</h1>
@endsection

@section('content')
  @component('components.admin.button-header')
   @include('partials.admin_partials.buttons.new-item-btn',['modal' => true,'target' => 'adminFormModal'])
  @endcomponent
  @include('partials.admin_partials.index_tables.administrators-table')

<div class="mt-5">
    {{ $admins->appends(request()->input())->links() }}
</div> 
<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'admin'])
@endsection
@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('adminFormModal','admin-form', "{{route('admin.administrators.index')}}");
})();
</script>
@endsection