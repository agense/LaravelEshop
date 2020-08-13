<form action="" id="slider-form" method="POST" class="w-100">     
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group">
            <label for="title">Title</label>
            <input  type="text" name="title" id="title" value="" class="form-control" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input  type="text" name="subtitle" id="subtitle" value="" placeholder="Subtitle" class="form-control">
        </div>
        <div class="form-group">
            <label for="link_text">Link Text</label>
            <small class="d-block">*This text will be displayed on the button link.</small>
            <input  type="text" name="link_text" id="link_text" value="" placeholder="Link Text" class="form-control">
        </div>
        <div class="form-group">
            <label for="link">Link</label>
            <input  type="text" name="link" id="link" value="" placeholder="Link" class="form-control">
        </div>
        <div class="form-group custom-file mt-2">
            <label for="image" class="custom-file-label">Upload Image</label>
            <input  type="file" name="image" id="image" class="custom-file-input">
        </div>
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-success btn-md">
                <span class="dynamic-title">Add Slide</span>
            </button>
        </div>
</form> 