@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Pages</h1>
@endsection

@section('content')
  @component('components.admin.button-header')
    @can('isAdmin')
        @include('partials.admin_partials.buttons.new-item-btn',['target' => 'admin.pages.create'])
    @endcan
  @endcomponent
  
@if(count($pages) > 0)
  @include('partials.admin_partials.index_tables.pages-table')
<div class="mt-5">
    {{ $pages->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">There are no pages.</div>
@endif   
@endsection
