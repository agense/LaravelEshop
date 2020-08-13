(function(){
  const imageManager = document.getElementById('image-manager');
  const modal = document.getElementById('imagesModal');
  const deleteImgArray = document.querySelectorAll('.delete-img');
  const errors = document.getElementById('errors');
  const success = document.getElementById('success-msg');
  const imageHolder = document.querySelector('.modal-images-holder');
  const uploadForm = document.getElementById('upload-form');
  const uloadImgUrl = $(uploadForm).attr('data-url');
  const deleteImgUrl = $(imageHolder).attr('data-delete-url');

  // EVENT LISTENERS
  // Delete a selected image
  //attaching event listener to parent element, to propagate to children 
  //(allows newly uploaded items to be accessible for delete)
  imageHolder.addEventListener('click', (e)=>{
    e.preventDefault();    
    if(e.target.classList.contains('delete-img')){
      const imgId = e.target.getAttribute('data-target');
      const targetUrl = deleteImgUrl.replace(':image_id', imgId);
      let image = e.target.parentElement; 
      deleteImage(targetUrl, image);
    }
  });

  //Upload new images
  uploadForm.addEventListener('submit', (e)=>{
    e.preventDefault();
    var data = new FormData(uploadForm);
    uploadImages(uloadImgUrl, data);
  });
  

  // AXIOS CALLS
  //Delete a selected single image via axios
  function deleteImage(targetUrl, image){
    axios.delete(targetUrl, {})
    .then(res => {
        removeItem(image);
        displayMessage(success, res.data['message']);    
    })
    .catch(err => {
        if(err.response.status == 404){
          displayMessage(errors, 'Image was not found'); 
        }else{
          displayMessage(errors, err.response.data.message); 
        }
    });
  }

  //Uploads images via axios
  function uploadImages(uloadImgUrl, data){
     axios({
      method: 'post',
      url: uloadImgUrl,
      data: data,
      config: { headers: {'Content-Type': 'multipart/form-data' }}
      })
      .then(response => {
        const result = response.data;
        displayMessage(success, result.message);    
        displayImages(result.images);
        uploadForm.reset();  
        removeSelections(); 
      })
      .catch(error => {
        handleErrors(error.response);
      });
  }
 
  // HELPER FUNCTIONS
  //Helper function - message display
  function displayMessage(element, message){
     element.innerHTML = message;
     element.style.display = "block";
     setTimeout(()=>{
        element.style.display = "none";
        }, 5000); 
  }
 
  //Helper function - display uploaded images
  function displayImages(imgArr){
     imageHolder.innerHTML = '';
     imgArr.forEach((image)=>{
        let singleImg = document.createElement('div');
        singleImg.classList.add('product-modal-image');
        singleImg.innerHTML = `
        <img src="${image.image_link}" alt="">
        <a href="#" class="delete-img" data-target="${image.id}">&times;</a>`;
        imageHolder.appendChild(singleImg);
     });
  }

  // ERROR HANDLER
  function handleErrors(resp){
     if(resp.status == 404){
       displayMessage(errors, 'Product was not found. Images cannot be uploaded.');
     }
     else if(resp.status == 400){
      displayMessage(errors, resp.data.message);
     }
     else if(resp.status == 422){
       let responseErrors = formatErrors(resp.data.errors);
       displayMessage(errors, responseErrors); 
     }else{
         displayMessage(errors, 'There was an error. Images cannot be uploaded.'); 
     }
  }
 
  // Formats errors into a list
  function formatErrors(errorData){
     let errors;
     if(typeof errorData == 'object'){
       errors = Object.entries(errorData);
     }
     let errorMessage = '<ul>';
     errors.forEach(function(err) {
         errorMessage += "<li>"+ err[1][0] +"</li>"
     });
     errorMessage += "</ul>";
     return errorMessage;
  }

   //Remove Custom Field Text
  function removeSelections(){
    let fields = document.querySelectorAll('.selected-el');
    fields.forEach((element)=>{
       element.parentElement.removeChild(element);
    });    
  }

  //Removes deleted image from DOM
  //If no images are left, creates a paragraph with text 
  function removeItem(item){
    imageHolder.removeChild(item);  
    if(imageHolder.childNodes.length == 0){
      let empty = document.createElement('p');
      empty.classList.add('no-images');
      empty.innerHTML = 'There are no images';
      imageHolder.appendChild(empty);
    }
  }
 })();