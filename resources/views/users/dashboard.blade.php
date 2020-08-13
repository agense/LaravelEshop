@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
    <div class="row">
        @include('partials.navigations.user-sidebar')
        <div class="col-md-9 my-5">
            <div class="panel panel-default">
            <h1>Dashboard</h1>
            <hr/><br/>    
            <div class="row">
            <div class="col-md-7">
                <div class="card border-secondary mb-3">
                   <div class="card-header">MY ACCOUNT DETAILS</div>
                   <div class="card-body">
                       <p class="card-text"><i class="far fa-user"></i> {{$user->name}}</p>
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
                       <div class="mt-3 w-100">
                            <a href="{{route('user.account.edit', $user->id)}}" class="btn-sm btn-dark-sm">Edit Profile</a>
                       </div>
                  </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-secondary mb-3">
                   <div class="card-header">MY ORDERS</div>
                   <div class="card-body">
                        <div class="bs-component">
                                <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Orders:
                                  <span class="badge badge-rounded">{{$orderCount['total']}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Completed:
                                  <span class="badge badge-rounded">{{$orderCount['complete']}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                   In Process:
                                  <span class="badge badge-rounded">{{$orderCount['active'] }}</span>
                                  </li>
                                </ul>
                                <div class="mt-4 w-100">
                                    <a href="{{route('user.orders.index')}}" class="btn-sm btn-dark-sm">View Orders</a>
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
