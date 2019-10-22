@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Categories</h1>
@endsection

@section('content')
@can('isAdmin')
<div class="mb-3">
    <form action="{{route('brands.store')}}" method="POST" class="form-inline">
        {{ csrf_field() }}
        <div class="form-group">
            <input  type="text" name="name" id="name" class="form-control" placeholder="New Brand Name">
        </div>
        <button type="submit" class="btn btn-success btn-md">Add New</button>
    </form>
  </div>
  <div class="separator"></div>
@endcan
@if(count($brands) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td>Brand Name</td>
            <td class="text-center">Brand Products</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($brands as $brand)
        <tr>
          <td>{{$brand->name}}</td>
          <td class="text-center">{{$brand->products_count}}</td>
          <td class="text-right">
              @can('isAdmin')
              <a href="{{route('brands.edit', $brand->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
              <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this brand?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
              @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
<div class="mt-5">
  {{ $brands->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no brands.</div>
@endif 
@endsection
