@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Administrators</h1>
@endsection

@section('content')
<div class="text-right mb-2">
    <a href="{{route('administrators.create')}}" class="btn btn-success btn-md">Add New</a>
</div>
  <div class="separator"></div>

<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($admins as $admin)
        <tr>
          <td>{{$admin->name}}</td>
          <td>{{$admin->email}}</td>
          <td>{{$admin->role}}</td>
          <td class="text-right">
              <a href="{{route('administrators.edit', $admin->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
              <form action="{{ route('administrators.destroy', $admin->id) }}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this administrator?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
          </td>
        </tr>
        @endforeach
    </tbody>
</table> 
<div class="mt-5">
    {{ $admins->appends(request()->input())->links() }}
</div> 
@endsection
