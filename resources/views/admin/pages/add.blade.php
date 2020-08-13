@extends('layouts.admin')

@section('extra-head')
<!--Summernote Text Editor CSS-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
@endsection

@section('title')
<h1 class="topnav-heading">Create New Page</h1>
@endsection

@section('content')
    @component('components.admin.button-header') 
        @include('partials.admin_partials.buttons.direction-btn',['routeUrl' => 'admin.pages.index', 'text' => 'Pages'])
    @endcomponent

    @component('components.admin.content-box') 
        @slot('title')
            New Page
        @endslot
        @slot('content')
            @include('partials.forms.page-form')
        @endslot
    @endcomponent
@endsection

@section('extra-footer')
<!--Summernote Text Editor JS and Instantiation-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<script type="text/javascript" src="{{ asset('js/admin/summernote.settings.js') }}"></script>
<script>
    $(document).ready(function() {
        initSummernote('content');
    });
</script>
@endsection