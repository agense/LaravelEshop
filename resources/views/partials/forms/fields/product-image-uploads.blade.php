<!--Featured Image Uploads-->
@if($product->featured_image !== null)
<div>
  <div class="featured-image-display mt-4">Featured Image</div>
  <div class="midi-img-bordered"><img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}"></div>
</div>
@else 
<div class="add-on-label">Featured Image</div>
@endif
<div class="form-group custom-file">
    <input  type="file" name="featured_image" id="featured_image" class="custom-file-input">
    <label for="featured_image"  class="custom-file-label" >
      {{ $product->featured_image !== null ? "Change" : "Upload"}} Featured Image</label>
    @if ($errors->has('featured_image'))
    <span class="fm-error">{{ $errors->first('featured_image')  }}</span>
    @endif
</div>
<!--Multiple Images Uploads-->
@if($product->id == null)
<div class="add-on-label">More Images</div>
<div class="form-group custom-file">
  <label for="images" class="custom-file-label">Select Images</label>
  <input  type="file" name="images[]" id="images" multiple class="custom-file-input">
</div>
@else 
<div>
  <a href="#" class="btn btn-dark-border btn-md w-100" id="image-manager" data-toggle="modal" data-target="#imagesModal">Manage Images</a>
</div>
@endif
