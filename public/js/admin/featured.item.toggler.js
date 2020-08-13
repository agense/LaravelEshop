/*CHECKBOX TOGGLER*/
(function(){
    const  featuredItems = $('.featured-item');
    $(featuredItems).each(function(index, element){
       $(element).on('click', function(e){
        const holder = e.target.parentElement;
        const targetUrl = holder.getAttribute('data-url');  
        axios.get(targetUrl)
        .then((response)=>{
            if(response.data.newvalue == 1){
              holder.innerHTML = '<i class="fi fi-check-mark"></i>';
              holder.style.color = "#18BC9C";
            }else{
              holder.innerHTML = '<i class="fi fi-square-line"></i>';
              holder.style.color = "#989898";
          }
          toastr.success(response.data.message);
        })
        .catch(function(error){
          if(error.response.status == 401 || error.response.status == 403){
            toastr.error(error.response.data.message);
          }else{
            toastr.error('There was an error.');
          }
        });
       })
    });
  })();