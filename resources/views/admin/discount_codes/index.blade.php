@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Active And Future Discount Codes</h1>
@endsection

@section('content')

@component('components.admin.button-header')
    @include('partials.admin_partials.buttons.direction-btn',[
        'routeUrl' => 'admin.codes.deactivated', 
        'text' => 'Deactivated Codes'
    ])
    @include('partials.admin_partials.buttons.direction-btn',[
        'routeUrl' => 'admin.codes.expired', 
        'text' => 'Expired Codes'
    ])
    @can('isAdmin')
        @include('partials.admin_partials.buttons.new-item-btn',['modal' => true,'target' => 'discountcodeFormModal'])
    @endcan
@endcomponent

@if(count($discountCodes))
 @include('partials.admin_partials.index_tables.discount-codes-table', ['manageOffers' => true])
<div class="mt-5">
    {{ $discountCodes->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no discount codes.</div>
@endif 
<!--Modal-->
@include('partials.modals.form-modal', ['type' => 'discountcode'])

@endsection
@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/admin/featured.item.toggler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/modal.form.js')}}"></script>
<script>
(function(){
    initModal('discountcodeFormModal','discountcode-form', "{{route('admin.codes.index')}}");
})();
</script>
@endsection