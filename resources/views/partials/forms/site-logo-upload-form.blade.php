<form action="{{route('admin.settings.logo')}}" method="POST" enctype="multipart/form-data" id="logo-upload-form">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group custom-file mb-3">
        <label for="logo" class="custom-file-label">Search...</label>
        <input  type="file" name="logo" id="logo" class="custom-file-input">
        @if ($errors->has('logo'))
            <span class="fm-error">{{ $errors->first('logo')  }}</span>
        @endif
    </div>
    <button type="submit" class="btn btn-success btn-md"><span>Upload</span></button>
</form>