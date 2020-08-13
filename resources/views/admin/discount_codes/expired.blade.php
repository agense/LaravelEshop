@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Expired Discount Codes</h1>
@endsection

@section('content')
    @component('components.admin.button-header')
        @include('partials.admin_partials.buttons.direction-btn',[
            'routeUrl' => 'admin.codes.deactivated', 
            'text' => 'Deactivated Codes'
        ])
        @include('partials.admin_partials.buttons.direction-btn',[
            'routeUrl' => 'admin.codes.index', 
            'text' => 'Active Codes'
        ])
    @endcomponent
@if(count($discountCodes))
 @include('partials.admin_partials.index_tables.discount-codes-table')
<div class="mt-5">
    {{ $discountCodes->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no expired discount codes.</div>
@endif 
<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'discountcode'])
@endsection
@section('extra-footer')
<script src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('discountcodeFormModal','discountcode-form', "{{route('admin.codes.index')}}");
})();
</script>
@endsection