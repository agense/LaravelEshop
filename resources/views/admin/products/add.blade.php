@extends('layouts.admin')
@section('content')
<div class="mb-5 row">
 <div class="col-lg-10 offset-lg-1 col-md-12">
    <h1>Add Product</h1>
    <div class="separator"></div>
    <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-6">       
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name</label>
            <input  type="text" name="name" id="name" value="{{Request::old('name')}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="categories">Categories</label><br>
                @foreach($categories as $category)
                <input type="checkbox" name="categories[]" value="{{$category->id}}" 
                {{ (old('categories') && in_array($category->id, old('categories'))) ? "checked" : ""}} >
                 {{$category->name}}<br>
                @endforeach
        </div>
        <div class="form-group">  
                <label for="brand">Brand</label>      
                <select name="brand" id="brand" class="form-control">
                        <option value="" {{ null == old('brand') ? "selected" : "" }} disabled>...</option>
                        @foreach($brands as $brand)
                        <option value="{{$brand->id}}" {{old('brand') == $brand->id ? "selected": ""}}>{{$brand->name}}</option>
                        @endforeach
                </select>   
        </div>
        <div class="form-group">
                <label for="price">Price</label>
                <input  type="text" name="price" id="price" value="{{Request::old('price')}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="availability">Availability</label>
                <input  type="number" min="0" name="availability" id="availability" value="{{Request::old('availability')}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="featured">Featured Product</label>
                <select name="featured" id="featured" class="form-control">
                        <option value="0" {{old('featured') == 0 ? "selected": "" }}>No</option>
                        <option value="1" {{old('featured') == 1 ? "selected": "" }}>Yes</option>
                </select>
        </div>
        </div>

        <div class="col-md-6">                    
        <div class="form-group">
                <label for="details">Details</label>
                <input type="text" name="details" id="details" value="{{Request::old('details')}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="description">Descritpion</label>
                <textarea name="description" id="description" class="form-control" rows="10">{{Request::old('description')}}</textarea>
        </div>
        <div class="form-group">
                <label for="featured_image">Featured Image</label><br>
                <input  type="file" name="featured_image" id="featured_image">
        </div>
        <div class="form-group">
                <label for="images">Product Images</label><br>
                <input  type="file" name="images[]" id="images" multiple>
        </div>
        <div class="text-right mt-5">
        <a href="{{route('products.index')}}" class="btn btn-primary btn-md mr-2">Back</a>        
        <button type="submit" class="btn btn-success btn-md">Create Product</button>
        </div>
        </div>
        </div>
    </form>    
</div>
</div>
@endsection