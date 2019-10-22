@extends('layouts.admin')
@section('title')
<h1 class="topnav-heading">{{$page->title}}</h1>
@endsection

@section('content')
<div class="mb-5">
        <div>
            {!!$page->content !!}
        </div>
</div>
<div class="actions">
<div><a href="{{route('pages.index')}}" class="btn btn-primary">Back</a></div>
<div>
@can('isAdmin')
<a href="{{route('pages.edit', $page->id)}}" class="btn btn-success">Edit</a>
<form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-primary" onclick="return confirm('Delete this page?')">Delete</button>
</form>
@endcan
</div>
</div>
@endsection
