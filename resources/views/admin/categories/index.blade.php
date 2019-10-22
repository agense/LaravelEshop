@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Categories</h1>
@endsection

@section('content')
@can('isAdmin')
<div class="mb-3">
    <form action="{{route('categories.store')}}" method="POST" class="form-inline">
        {{ csrf_field() }}
        <div class="form-group">
            <input  type="text" name="name" id="name" class="form-control" placeholder="New Category Name">
        </div>
        <button type="submit" class="btn btn-success btn-md">Add New</button>
    </form>
  </div>
  <div class="separator"></div>
@endcan
@if(count($categories) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td>Category Name</td>
            <td class="text-center">Products In</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{$category->name}}</td>
          <td class="text-center">{{$category->products_count}}</td>
          <td class="text-right">
              @can('isAdmin')
              <a href="{{route('categories.edit', $category->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>

              <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this category?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
              @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
@else 
<div class="no-items">There are no categories.</div>
@endif 
@endsection
