@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Deleted Products</h1>
@endsection
@section('content')
@if(count($products) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td></td>
            <td>Name</td>
            <td>Brand</td>
            <td>Price</td>
            <td class="text-center">Items Sold</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
          <td>
            <div class="table-img">
              <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
            </div>
          </td>  
          <td>{{$product->name}}</td>
          <td>{{strtoupper($product->brand->name)}}</td>
          <td>{{$product->displayPrice()}}</td>
          <td class="text-center">{{$product->orders_count}}</td>
          <td class="text-right table-col-wide">
            @can('isAdmin')
              <a href="{{route('admin.product.restore', $product->id)}}" class="btn btn-success btn-sm">Restore</a>
              <form action="{{route('admin.product.finaldelete', $product->id)}}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('This action is irreversible. Delete this product?')">Final Delete</button>
              </form>
            @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table> 
<div class="mt-5">
  {{ $products->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no deleted products.</div>
@endif 
@endsection