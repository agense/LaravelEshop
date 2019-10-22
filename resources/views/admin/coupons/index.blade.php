@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Discount Cards</h1>
@endsection

@section('content')
@can('isAdmin')
<div class="text-right mb-4">
        <a href="{{route('coupons.create')}}" class="btn btn-success btn-md">Add New</a>
</div>
@endcan
@if(count($coupons))
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td class="w-25">Code</td>
            <td class="w-25">Discount Type</td>
            <td class="w-25">Discount Value</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
          <td class="w-25">{{$coupon->code}}</td>
          <td class="w-25">{{ucfirst($coupon->type)}}</td>
          <td class="w-25">{{$coupon->displayDiscount()}}</td>
          <td class="text-right">
              @can('isAdmin')
              <a href="{{route('coupons.edit', $coupon->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
              <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this discount card?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
              @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
<div class="mt-5">
    {{ $coupons->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no discount cards.</div>
@endif 
@endsection
