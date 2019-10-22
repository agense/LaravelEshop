@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="panel panel-default">
            <h1>My Account</h1>
            <hr/><br/>    
            <div class="row">
            <div class="col-md-7">
                <div class="card border-secondary mb-3">
                   <div class="card-header card-header-dark">MY PROFILE</div>
                   <div class="card-body">
                       <p class="card-text"><i class="fi fi-male"></i> {{$user->name}}</p>
                       <p class="card-text"><i class="fi fi-envelope"></i> {{$user->email}}</p>
                       @if($user->phone != null)
                       <p class="card-text"><i class="fi fi-mobile"></i> {{$user->phone}}</p>
                       @endif
                       @if($user->address != null)
                       <p class="details-text"><span>ADDRESS:</span></p>
                       <p class="card-text">
                           <span>{{$user->address}}</span><br/>
                            @if($user->city != null)
                                <span>{{$user->city}}, </span>
                            @endif
                            @if($user->region != null)
                                <span>{{$user->region}}</span><br/>
                            @endif
                            @if($user->postalcode != null)
                                <span>PC: {{$user->postalcode}} </span>
                            @endif
                       </p>
                       @endif
                       <div class="mt-4 w-100">
                            <a href="{{route('userAccount.edit', $user->id)}}" class="button-dark-border-md">Edit Profile</a>
                       </div>
                  </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-secondary mb-3">
                   <div class="card-header card-header-dark">MY ORDERS</div>
                   <div class="card-body">
                        <div class="bs-component">
                                <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Orders:
                                  <span class="badge badge-primary badge-pill">{{$totalOrders}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Completed:
                                  <span class="badge badge-success badge-pill">{{$completedOrders}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                   In Process:
                                  <span class="badge badge-warning badge-pill">{{ $inProgressOrders }}</span>
                                  </li>
                                </ul>
                                <div class="mt-4 w-100">
                                    <a href="{{route('user.orders')}}" class="button-dark-border-md">View Orders</a>
                                </div>
                  </div>
                </div>
            </div>
            </div>
            </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
