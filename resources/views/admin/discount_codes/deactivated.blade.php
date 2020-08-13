@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Deactivated Discount Codes</h1>
@endsection

@section('content')
@component('components.admin.button-header')
    @include('partials.admin_partials.buttons.direction-btn',[
        'routeUrl' => 'admin.codes.expired', 
        'text' => 'Expired Codes'
    ])
    @include('partials.admin_partials.buttons.direction-btn',[
        'routeUrl' => 'admin.codes.index', 
        'text' => 'Active Codes'
    ])
@endcomponent

@if(count($discountCodes))
@include('partials.admin_partials.index_tables.discount-codes-table', ['deactivatedView' => true])
<div class="mt-5">
    {{ $discountCodes->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no deactivated discount codes.</div>
@endif 
@endsection
