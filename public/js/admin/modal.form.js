function initModal(modalName, formName, baseUrl){ 
  
  //On modal open, clear errors and input data
  $(`#${modalName}`).on('show.bs.modal', function (e) {
    clearModal();
    $('.selected-el').remove();
    $('.dynamic-title').text(e.relatedTarget == undefined ? 'Update' : 'Add New')
  })

  // Show edit modal on edit btn click
  $('.edit-modal').click(function() {
    let target = $(this).attr('data-id');
    showForm(target);
  });
   
    // On form submission, create a request 
    $(`#${formName}`).submit(function(e){
     e.preventDefault();
     let target = $(this).attr('data-id');  
     let targetUri = (target !== undefined)  ? `${baseUrl}/${target}` : `${baseUrl}`;
     let method = (target !== undefined)  ?  'PUT' : 'POST';

     getFormData().then(data =>{
       submitForm(targetUri,method,data);
     }).catch(error =>{
        toastr.error('Sorry, there was an error.');
    })
  });


  // Get specific row data
  function showForm(target){
    axios.get(`${baseUrl}/${target}/edit`)
    .then(function(response){
      $(`#${modalName}`).modal().show(); 
      $(`#${formName}`).attr('data-id', response.data.id);
      appendDataToForm(response.data);
    })
    .catch(function(error) {
      if(error.response.indexOf("DOMException") == -1){
        toastr.error('Sorry, there was an error.');
      }
    });
  }

  // update form
  function submitForm(targetUri,method,data){
    axios({ 
      method: method, 
      url: targetUri, 
      data: data, 
      config: { headers: {'Content-Type': 'application/json'}}
    })
    .then(function(response){   
      location.reload(true); 
    })
    .catch(function (error) {
      handleErrors(error.response);
    });
  }

  function appendDataToForm(data){
    for (let [key, value] of Object.entries(data)) {
          $(`#${formName}`).find(`#${key}`).val(data[`${key}`]); 
    }
  }
 function getFormData(){
    return new Promise((resolve, reject) => {
      let data = {};
      let selectors = $('input, textarea, select, date').not(':input[type=file],:input[type=button], :input[type=submit], :input[type=hidden]');
      $(`#${formName}`).find(selectors).each(function(){
          data[$(this).attr('name')] = $(this).val();
      });
      if(!filesExist()){
        resolve(data);
      }else{   
        let fileInputs = $('input[type=file]'); 
        let file = fileInputs[0];
        let filename = $(file).attr('name');
        setFormFile(file.files[0]).then(
          imagedata => {
            data[filename] = imagedata;
            resolve(data);
          }
        );
      }   
    });
  }

  function handleErrors(response){
    $('.fm-error').remove();
    if(response.status == 422){
      displayErrors(response.data.errors);
    }else{
      toastr.error('Sorry, there was an error.');
    }
  }

  function displayErrors(err){
    for (let [key, value] of Object.entries(err)) {
      $(`#${formName}`).find(`#${key}`).parent().append(`<span class="fm-error">${value}</span>`)
    }
  }

  function clearModal(){
    $(`#${formName}`).each(function(){
        $(this).find(':input').val('');
        $(this).find(".fm-error").remove();
    });
    $(`#${formName}`).removeAttr('data-id');
    $(`#${formName}`).remove(".fm-error");
  }

  function setFormFile(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = error => reject(error);
    });
  }

  function filesExist(){
    let fileInputs = $('input[type=file]');
    if(fileInputs.length == 0 || fileInputs[0].files.length == 0){
      return false
    }
    return true;
  }
}