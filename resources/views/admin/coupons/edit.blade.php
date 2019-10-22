@extends('layouts.admin')
@section('content')
<div class="mb-5 row">
<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
<h1>Edit Discount Card</h1>
<div class="separator"></div>
    <form action="{{route('coupons.update', $card->id)}}" method="POST">     
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="code">Code</label>
            <input  type="text" name="code" id="code" value="{{Request::old('code') ?? $card->code}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="type">Select Discount Card Type</label>
                <select name="type" id="type" class="form-control">
                    @foreach($types as $type)
                    <option value="{{$type}}" {{$card->type == $type ? "selected" : ""}}>{{ucfirst($type)}}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="slug">Value</label>
            <input  type="text" name="value" id="value" value="{{Request::old('value') ?? $card->displayValue()}}" class="form-control">
        </div>
        <div class="text-right mt-5">
        <a href="{{route('coupons.index')}}" class="btn btn-primary btn-md mr-2">Back</a>        
        <button type="submit" class="btn btn-success btn-md">Update Card</button>
        </div>
    </form>    
</div>
</div>
@endsection