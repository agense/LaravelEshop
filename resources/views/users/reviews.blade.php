@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.navigations.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="panel panel-user">
            <h1>Review Products</h1>
            <hr/>
            <div class="panel-body">
                @if(count($products) > 0)
                <div class="md-header mb-3">Ordered Products</div>   
                @foreach($products as $product)
                    @include('partials.review_partials.user-review-box')
                @endforeach
                <div class="mt-5">
                        {{$products->appends(request()->input())->links()}}
                </div> 
                @else
                <div class="no-items py-5 text-center">
                    <div class="md-header mb-3 ">There are no products in your order list yet</div>
                    <div>You can only review products you have purchased.</div> 
                </div>  
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/scripts/togglers.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/reviewform.toggler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/scripts/reviewform.handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/delete.confirmation.js') }}"></script>
<script>
$(document).ready(function(){
    initTogglers('opn-show', 'review_', true, 'Show Review', 'Hide Review');
    initTogglers('opn-create', 'product_');
});
</script>
@endsection