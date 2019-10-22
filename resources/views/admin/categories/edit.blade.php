@extends('layouts.admin')
@section('content')
<div class="mb-5 row">
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
    <h1>Edit Category</h1>
    <div class="separator"></div>   
    <form action="{{route('categories.update', $category->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="name">Name</label>
        <input  type="text" name="name" value="{{$category->name}}" id="name" class="form-control">
        </div>
        <div class="text-right mt-5">
        <a href="{{route('categories.index')}}" class="btn btn-primary btn-md mr-2">Back</a>      
        <button type="submit" class="btn btn-success btn-md">Update Category</button>
        </div>
    </form>
    </div>
  </div>
@endsection