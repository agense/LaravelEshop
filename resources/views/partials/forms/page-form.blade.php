<form action="{{$page->id == null ? route('admin.pages.store') : route('admin.pages.update', $page->id)}}" 
    method="POST" id="page-form" data-target="{{route('admin.pages.store')}}">     
    {{ csrf_field() }}
    @if($page->id !== null)
    {{ method_field('PUT')}}
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Title</label>
                <input  type="text" name="title" id="title" value="{{old('title', $page->title)}}" class="form-control">
                @if ($errors->has('title'))
                <span class="fm-error">{{ $errors->first('title')  }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            @include('partials.forms.fields.page-type-select')
        </div>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control">{{old('content', $page->content)}}</textarea>
        @if ($errors->has('content'))
        <span class="fm-error">{{ $errors->first('content')  }}</span>
        @endif
    </div>
    <div class="text-right mt-5">      
    <button type="submit" class="btn btn-success btn-md">
        {{$page->id == null ? 'Create Page' : 'Update Page'}}
    </button>
    </div>
</form>    