@extends('layouts.admin')

@section('extra-head')
<!--Summernote Text Editor CSS-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
@endsection

@section('content')
<div class="mb-5 row">
<div class="col-lg-10 offset-lg-1 col-md-12">
<h1>Edit Page</h1>
<div class="separator"></div>
    <form action="{{route('pages.update', $page->id)}}" method="POST">     
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input  type="text" name="title" id="title" value="{{old('title') ?? $page->title }}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Page Type</label>
                    <select name="type" id="type" class="form-control">
                        @foreach($types as $type)
                        <option value="{{$type}}" {{$page->type == $type ? "selected" : ""}}>{{ucfirst($type)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="20">{{old('content') ?? $page->content}}</textarea>
        </div>
        <div class="text-right mt-5">
        <a href="{{route('pages.index')}}" class="btn btn-primary btn-md mr-2">Back</a>        
        <button type="submit" class="btn btn-success btn-md">Update Page</button>
        </div>
    </form>    
</div>
</div>
@endsection

@section('extra-footer')
<!--Summernote Text Editor JS and Instantiation-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            callbacks: {
                onMediaDelete : function($target, editor, $editable) {
                //console.log($target);
                deletePageFile($target);   
                }
            },
            toolbar: [               
                ['style', ['style','bold', 'italic', 'underline', 'clear']],
                ['font', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['hr','table','link', 'picture']],
                ['view', ['fullscreen','codeview']],
            ],
        });
        
        function deletePageFile($target){
            let filepath = $target[0].currentSrc;
            // Send ajax request via axios
            axios.post('/admin/pages/deletePageImage', {
                fileurl: filepath
            })
            .then(function(response){
                if(response.data == true){
                    // remove element in editor 
                    $target.remove();
                    toastr.success('File Deleted! Update this page before closing it to prevent errrors.');
                }else{
                    toastr.error('Sorry, there was an error.');
                }
            })
            .catch(function(error){
                toastr.error(error);
            });
        }
         
    });
  </script>
@endsection