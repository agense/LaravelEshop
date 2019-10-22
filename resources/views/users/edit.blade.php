@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1>Update My Profile</h1>
                <hr/><br/>
                @if($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                      @foreach($errors->all() as $error)
                      <li>{{$error}}</li>
                      @endforeach
                    </ul>
                    </div>
                @endif
                <div class="panel-body">
                <form action="{{route('userAccount.update')}}" method="POST">
                <div class="grid-split">
                    <div>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name )}}" class="form-control" required>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-Mail</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <span class="badge">* Leave the field blank to keep your current password</span>
                        <input id="password" type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div>   
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="form-group">
                                <label for="address">Address</label>
                                <input type="address" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                          </div>
                          <div class="form-group">
                                <label for="city">City</label>
                                <input type="city" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}">
                        </div>
                          <div class="half-form">
                                <div class="form-group">
                                        <label for="region">Region</label>
                                        <input type="region" class="form-control" id="region" name="region" value="{{ old('region', $user->region) }}">
                                </div>
                                <div class="form-group">
                                        <label for="postalcode">Postal Code</label>
                                        <input type="postalcode" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode', $user->postalcode) }}">
                                </div>
                          </div>      
                            <div class="text-right mt-4 mb-5">
                                <button type="submit" class="button-dark-border-md">Update Profile</button>
                            </div>
                    </div>    
                    </div>    
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection