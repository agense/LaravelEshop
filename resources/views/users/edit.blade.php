@extends('layouts.app')

@section('content')
<div class="container user-account-holder">
        <div class="row">
            @include('partials.navigations.user-sidebar')
            <div class="col-md-9 my-5">
                <div class="panel panel-user">
                <h1>Update My Account</h1>
                <hr/><br/>
                <div class="panel-body">
                    <div class="card border-secondary mb-3">
                        <div class="card-header side-split order-header">
                            <div class="md-header">Account Details</div>
                        </div>
                        <div class="card-body">
                            @include('partials.forms.user-account-form')
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection