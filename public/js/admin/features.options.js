
(function(){
    const optionHolder = document.querySelector('.feature-options');
    const buttons = document.querySelectorAll('.feature-options-modal-btn');
    const itemAddForm = document.getElementById('add-feature-option-form');
    
    //EVENT LISTENERS
    // Enable modal on btn click
    buttons.forEach((element)=>{
      element.addEventListener('click', (e)=>{
        e.preventDefault();
        let targetUrl = e.target.getAttribute('data-url');
        showData(targetUrl);
      })
    });

    //Enable option deleting
    optionHolder.addEventListener('click', (e) => {
        if(e.target.classList.contains('removal')){
          let targetUrl = $('.feature-options').attr("data-delete-target");
          let data = {
            'option': $(e.target).parent().find('.el_value').attr('data-val')
          };
          removeOption(data, targetUrl);
        }
    });

    //Enable Option Adding
    itemAddForm.addEventListener('submit', (e) => {
       e.preventDefault();
       let targetUrl = $(itemAddForm).attr("data-target");
       let data = {
         'option': $(itemAddForm).find('#option').val()
       }; 
       addOption(data, targetUrl);
    });
 
  // INNER FUNCTIONS
  // Show Data 
  function showData(targetUrl){
    clearModal();
    axios.get(targetUrl)
    .then(function(response){
        $('#feature-options-modal').modal().show();
        $('.feature-name').text(response.data.name);
        $(itemAddForm).attr("data-target", response.data.option_updates.add.url);
        displayOptions(response.data.options, response.data.option_updates.remove.url);
    })
    .catch(function(error) {
      if(error.response.indexOf("DOMException") == -1){
        toastr.error('Sorry, there was an error.');
      }
    });
  }

  //Delete Option
  function removeOption(data, targetUrl){
    axios({ 
      method: 'DELETE', 
      url: targetUrl, 
      data: data, 
      config: { headers: {'Content-Type': 'application/json'}}
    })
    .then(function(response){   
      displayOptions(response.data.options);
      toastr.success('Option has been removed');
    })
    .catch(function (error) {
      if(error.response.status == 422){
        toastr.error(error.response.data.message);
      }else{
        toastr.error('Sorry, there was an error.');
      }
    });
  }

  //Add New Option
  function addOption(data, targetUrl){
    axios({ 
      method: 'PUT', 
      url: targetUrl, 
      data: data, 
      config: { headers: {'Content-Type': 'application/json'}}
    })
    .then(function(response){   
      $(itemAddForm).find('#option').val('');
      displayOptions(response.data.options);
      $('.fm-error').remove();
      toastr.success('Option has been added.');
    })
    .catch(function (error) {
      handleErrors(error.response);
    });
  }

  //Display Options
  function displayOptions(options, deleteOptionUrl){
    $(optionHolder).empty();
    $(optionHolder).attr("data-delete-target", deleteOptionUrl);
    if(options.length == 0){
      let item = '<div>There are no options for this feature.</div>';
      $(optionHolder).append(item);
    }else{
      options = Object.values(options);
      options.forEach((element)=>{
        let item = '<div class="f-option">'
        +'<span class="el_value capitalize" data-val="'+element+'">'+element.replaceAll('_', ' ')+'</span>'
        +'<span class="removal">&#10005;</span></div>';
        $(optionHolder).append(item);
      });
    }
  }

  // Handle Upload Option Errors
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
      $(itemAddForm).find(`#${key}`).parent().append(`<span class="fm-error">${value}</span>`)
    }
  }

  function clearModal(){
    $(itemAddForm).each(function(){
        $(this).find(':input').val('');
        $(this).find(".fm-error").remove();
    });
    $(optionHolder).empty();
  }
})();