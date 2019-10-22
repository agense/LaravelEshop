@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Pages</h1>
@endsection

@section('content')
@can('isAdmin')
<div class="text-right mb-4">
        <a href="{{route('pages.create')}}" class="btn btn-success btn-md">Add Page</a>
</div>
@endcan
@if(count($pages) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td class="w-25">Title</td>
            <td class="w-25">Type</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($pages as $page)
        <tr>
          <td class="w-25">{{ ucfirst($page->title) }}</td>
          <td class="w-25">{{ ucfirst($page->type) }}</td>
          <td class="text-right">
              <a href="{{route('pages.show', $page->id)}}" class="btn btn-warning btn-sm"><i class="fi fi-eye"></i></a>
              @can('isAdmin')
              <a href="{{route('pages.edit', $page->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>

              <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this page?')"><i class="fi fi-recycle-bin-line"></i></button>
              </form>
              @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-5">
    {{ $pages->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no pages.</div>
@endif   
@endsection
