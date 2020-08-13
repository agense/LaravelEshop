@extends('layouts.auth-admin')

@section('content')
<div class="auth-form">
    <div class="panel panel-default">
        <div class="panel-heading">Forgot My Password</div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('admin.password.email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Send Password Reset Link
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
