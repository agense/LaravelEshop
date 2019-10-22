@extends('layouts.admin')

@section('content')
<div class="mb-5 row">
<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
<h1>Add An Administrator</h1>
<div class="separator"></div>
    <form action="{{route('administrators.store')}}" method="POST">     
        {{ csrf_field() }}
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                @foreach($roles as $role)
                <option value="{{$role}}" {{old('role') == $role ? "selected" : ""}}>{{ucfirst($role)}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input  type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">Email</label>
            <input  type="text" name="email" id="name" value="{{old('email')}}" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input  type="password" name="password" id="password" value="" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input  type="password" name="password_confirmation" id="password_confirmation" value="" class="form-control">
        </div>
        <div class="text-right mt-5">
        <a href="{{route('administrators.index')}}" class="btn btn-primary btn-md mr-2">Back</a>        
        <button type="submit" class="btn btn-success btn-md">Create Administrator</button>
        </div>
    </form>    
</div>
</div>
@endsection
