@extends('layouts.admin')
@section('content')
<div class="mb-5 row">
<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
<h1>Add Discount Card</h1>
<div class="separator"></div>
    <form action="{{route('coupons.store')}}" method="POST">     
        {{ csrf_field() }}
        <div class="form-group">
            <label for="code">Code</label>
            <input  type="text" name="code" id="code" value="{{Request::old('code')}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="type">Select Discount Card Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="" disabled {{null == old('type') ? "selected" : ""}} >...</option>
                    @foreach($types as $type)
                    <option value="{{$type}}" {{old('type') == $type ? "selected" : ""}}>{{ucfirst($type)}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="slug">Value</label>
            <input  type="text" name="value" id="value" value="{{Request::old('value')}}" class="form-control">
        </div>
        <div class="text-right mt-5">
        <a href="{{route('coupons.index')}}" class="btn btn-primary btn-md mr-2">Back</a>        
        <button type="submit" class="btn btn-success btn-md">Create Card</button>
        </div>
    </form>    
</div>
</div>
@endsection