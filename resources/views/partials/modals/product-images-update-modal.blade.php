<!-- Modal -->
<div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imagesModalLabel">Manage Product Images</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" id="errors"></div>   
          <div class="alert alert-success" id="success-msg"></div>  
          <div class="modal-images-holder" data-delete-url="{{route('admin.products.images.delete', ':image_id')}}">   
          @if(count($product->images) > 0)
                @foreach($product->images as $image)
                <div class="product-modal-image">
                  <img src="{{asset($image->image_link)}}" alt="">
                  <a href="#" class="delete-img" data-target="{{$image->id}}">&times;</a>
                </div>
                @endforeach
          @else
          <p class="no-images">There are no images</p>
          @endif
          </div>
        </div>
        <div class="modal-footer images-modal-footer">   
           <form action="" method="POST" enctype="multipart/form-data" class="images-modal-form" id="upload-form" data-url="{{route('admin.products.images.update')}}">
              {{ csrf_field() }}
              <input type="hidden" name="product_id" value="{{$product->id}}">
              <div class="form-group custom-file">
                <label for="images" class="custom-file-label">New Images</label>
                <input  type="file" name="images[]" id="images" multiple class="custom-file-input">
              </div>
              <button type="submit" class="btn btn-success btn-md">Upload</button>
            </form> 
            <button type="button" class="btn btn-primary btn-md finish-btn" data-dismiss="modal">Finish</button>   
        </div>
      </div>
    </div>
  </div>