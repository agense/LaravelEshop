@extends('layouts.app')
@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
        <div class="container-narrow">
        <a href="{{route('pages.landing')}}">Home</a>
        <span>></span>
        <a href="{{route('pages.page.show', $page->slug)}}">{{ ucfirst($page->title) }}</a>
    </div>
    </div>   
<div class="container-narrow page my-5">
<div class="mb-5">
    <div>
        <h1 class="lead-heading">{{$page->title}}</h1>
        <div class="separator"></div>
        <div class="pb-5 summernote-content">
            {!!$page->content !!}
        </div>
    </div>
</div>
</div>
@endsection
@section('extra-footer')
<script>
    $(document).ready(function(){
        let floatedLeft = $('.note-float-left');
        let floatedRight = $('.note-float-right');
        $(floatedLeft).each(function(index, element){
            element.parentElement.classList.add('clearfix');
        });
        $(floatedRight).each(function(index, element){
            element.parentElement.classList.add('clearfix');
        });
    }
    );
</script>
@endsection