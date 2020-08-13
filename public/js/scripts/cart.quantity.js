(function(){
    const qtySelectors = document.querySelectorAll('.quantity')
    Array.from(qtySelectors).forEach(function(element){
       element.addEventListener('change', function(e){
           e.preventDefault();
           const product_id = element.getAttribute('data-product');
           const targetUrl = element.getAttribute('data-url');
           // Send ajax request via axios
           axios.patch(targetUrl, {
               quantity: this.value,
               product: product_id
           })
           .then((response)=>{
               location.reload(true);
           })
           .catch((error) => {
              //restore the value to previously selected element
              this.value = $(this).find("option[selected]").val();
              const response = error.response
              if(response.status == 422){
                  toastr.error(response.data.errors.quantity[0]);
              }else{
                  toastr.error("Sorry, there was an error. Please try again.");
              }
              });
       })
    });
    $('[data-toggle="tooltip"]').tooltip();
  })();