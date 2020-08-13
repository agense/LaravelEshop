/* EDIT QUANTITY & MODAL FUNCTIONALITY */
(function(){
    $('#editQtyModal').on('show.bs.modal',(e) => {
      //Remove any previous errors and input from the modal
      $('.fm-errors').html("").hide();
      const currentQty = $(e.relatedTarget).find('.product-quantity').html().trim();
      $('#newquantity').attr('value', currentQty); 

      //Handle form submit
      $('#qtyUpdateForm').one('submit', (event) => {
          event.preventDefault();
          let qty = $('#newquantity').val();
  
          //front end error validation
          let validation = validateQuantity(qty);
          if(validation == true){
              updateProductQty(e.relatedTarget, qty);
          }else{
            displayErrors(validation);
          }
        })
    });
  
    // AXIOS request to update quantity
    function updateProductQty(targetProduct, qty){
        const targetUrl = targetProduct.getAttribute('data-url');
        axios.post(targetUrl, {
          'newquantity' : qty
        })
        .then((response)=>{
          $(targetProduct).find('span.product-quantity').html(qty);
          $('#editQtyModal').modal('hide');
          toastr.remove();
          toastr.success(response.data.message)
        })
        .catch(function (error) {
          handleErrors(error.response);
        });
    }
  
    // Handle response errors
    function handleErrors(response){
      if(response.status == 422){
        displayErrors(response.data.errors.newquantity);
      }else{
        displayErrors(["There was an error. Please try again"]);
      }
    }
  
    //Format and display errors 
    function displayErrors(err){
      let errors = "";
        $(err).each(function(index, element){
          errors += '<div class="fm-error">'+ element + '</div>';
        });
        $('.fm-errors').html(errors).show();
    }
    
    //Front end validation
    function validateQuantity(qty){
      let errors = [];
      if(qty == ""){
        errors.push('Quantity is required');
      }else if(qty < 0){
        errors.push('Quantity cannot be less than 0');
      }
      if(errors.length == 0){
        return true;
      }
      return errors;
    }
  })();