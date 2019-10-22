@extends('layouts.admin')

@section('content')
<div class="mb-5 row">
<div class="col-lg-10 offset-lg-1 col-md-12">
    <h1>Edit: {{$product->name}}</h1>
    <div class="separator"></div>
    <form action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-6">       
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="name">Name</label>
            <input  type="text" name="name" id="name" value="{{$product->name}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="categories">Categories</label><br>
                @foreach($categories as $category)
                @if(in_array($category->id, $selected))
                <input type="checkbox" name="categories[]" value="{{$category->id}}" checked> {{$category->name}} <br>
                @else
                <input type="checkbox" name="categories[]" value="{{$category->id}}"> {{$category->name}} <br>
                @endif
                @endforeach
        </div>
        <div class="form-group">  
            <label for="brand">Brand</label>      
            <select name="brand" id="brand" class="form-control">
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}" {{$product->brand->id == $brand->id ? "selected": ""}}>{{$brand->name}}</option>
                    @endforeach
            </select>   
        </div> 
        <div class="form-group">
                <label for="price">Price</label>
                <input  type="text" name="price" id="price" value="{{$product->price/100}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="availability">Availability</label>
                <input  type="number" min="0" name="availability" id="availability" value="{{$product->availability}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="featured">Featured Product</label>
                <select name="featured" id="featured" class="form-control">
                    <option value="0" {{$product->featured == 0 ? 'selected': ''}}>No</option>
                    <option value="1" {{$product->featured == 1 ? 'selected': ''}}>Yes</option>
                </select>
        </div>
        </div>

        <div class="col-md-6">  
        <div class="form-group">
                <label for="details">Details</label>
                <input type="text" name="details" id="details" value="{{$product->details}}" class="form-control">
        </div>
        <div class="form-group">
                <label for="description">Descritpion</label>
                <textarea name="description" id="description" class="form-control">{{$product->description}}</textarea>
        </div>
        @if($product->featured_image !== null)
        <div>
          <p>Featured Image</p>
          <div class="midi-img-bordered"><img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}"></div>
        </div>
        @endif
        <div class="form-group">
            <label for="featured_image">{{($product->featured_image !== null) ? 'Change' : 'Add' }} Featured Image</label><br>
            <input  type="file" name="featured_image" id="featured_image">
        </div>
        <div class="text-right">
          <a href="#" class="btn btn-success btn-md" id="image-manager" data-toggle="modal" data-target="#imagesModal">Manage Images</a>
        </div>
        <div class="text-right mt-5">
        <a href="{{route('products.index')}}" class="btn btn-primary btn-md mr-2">Back</a> 
        <button type="submit" class="btn btn-success btn-md">Update Product</button>
        </div>
        </div>
        </div>
    </form>  
</div>   
</div>
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
                      <div class="modal-images-holder">   
                      @if(count($productImages) > 0)
                            @foreach($productImages as $image)
                            <div class="product-modal-image">
                              <img src="{{asset('img/products/'.$image->path)}}" alt="">
                              <a href="#" class="delete-img" data-target="{{$image->id}}">&times;</a>
                            </div>
                            @endforeach
                      @else
                      <p class="no-images">There are no images</p>
                      @endif
                      </div>
                    </div>
                    <div class="modal-footer">    
                       <form action="" method="POST" enctype="multipart/form-data" class="fm-inline" id="upload-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="form-group">
                            <label for="images">Upload New Images</label><br>
                            <input  type="file" name="images[]" id="images" multiple>
                        </div>
                        <button type="submit" class="btn btn-success btn-md">Upload</button>
                        </form> 
                        <button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Finish</button>  
                    </div>
                  </div>
                </div>
              </div>
<!--EndModal-->              
@endsection
@section('extra-footer')
<script>
   (function(){
 
     const imageManager = document.getElementById('image-manager');
     const modal = document.getElementById('imagesModal');
     const deleteImgArray = document.querySelectorAll('.delete-img');
     const errors = document.getElementById('errors');
     const success = document.getElementById('success-msg');
     const imageHolder = document.querySelector('.modal-images-holder');
     const uploadForm = document.getElementById('upload-form');
     
     //Delete selected single image
     //attaching event listener to parent element, to propagate to children (allows newly uploaded items to be accessible for delete)
     imageHolder.addEventListener('click', (e)=>{
           e.preventDefault();    
           if(e.target.classList.contains('delete-img')){
            let imgId = e.target.getAttribute('data-target');
            let image = e.target.parentElement; 
            // Send ajax request via axios
            axios.delete(`/admin/product/deleteimage/${imgId}`, {
                 })
                 .then(function(response){
                     if(response.data[0] == "error"){
                       displayMessage(errors, response.data[1]);  
                     }else if(response.data[0] == "success"){
                       imageHolder.removeChild(image);  
                       displayMessage(success, response.data[1]);    
                     }
                 })
                 .catch(function(error){
                    displayMessage(errors, error); 
                 });
           }
     });
     
     //Upload new images
     uploadForm.addEventListener('submit', (e)=>{
        e.preventDefault();
        var data = new FormData(uploadForm);
        // Send ajax request via axios
        axios({
        method: 'post',
        url: '/admin/product/updateimages',
        data: data,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function(response){
             if(response.data[0] == "error"){
                displayMessage(errors, response.data[1]);  
             }else if(response.data[0] == "success"){
              if(imageHolder.firstElementChild.classList.contains('no-images')){
                imageHolder.firstElementChild.style.display = "none";
              }
                displayMessage(success, response.data[1]);    
                displayImages(response.data[2]);
                uploadForm.reset(); 
             }    
        })
        .catch(function(error){
          displayMessage(errors, error); 
        });
        });

     //Helper function - message display
     function displayMessage(element, message){
        element.innerHTML = message;
        element.style.display = "block";
        setTimeout(()=>{
           element.style.display = "none";
           }, 10000); 
     }

     //Helper function - display uploaded images
     function displayImages(imgArr){
        imgArr.forEach((image)=>{
           let singleImg = document.createElement('div');
           singleImg.classList.add('product-modal-image');
           singleImg.innerHTML = `
           <img src="${image.path}" alt="">
           <a href="#" class="delete-img" data-target="${image.id}">&times;</a>`;
           imageHolder.appendChild(singleImg);
        });
     }

    })();
</script>
@endsection