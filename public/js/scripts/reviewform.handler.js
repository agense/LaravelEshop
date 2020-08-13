(function(){
    const fmSelectors = document.querySelectorAll('.rv-form');
    Array.from(fmSelectors).forEach(function(element){
        element.addEventListener('submit', function(e){
            handleReview(e, element);
        });
    });

    async function handleReview(e, element){
        e.preventDefault();
        const targetUrl = element.getAttribute('data-url');
        const id = element.getAttribute('data-id');

        const reviewContent = $(element).find('#review');
        const rating = $(element).find('#rating');
        const data = {
            review: $.trim($(reviewContent).val()),
            rating: $(rating).val(),
        }
        const dataErrors = validationErrors(data);
        if(dataErrors){
            displayErrors(dataErrors, element);
        }else{
            try{
                await handleRequest(data, targetUrl, id);
                location.reload(true);
            }catch(err){
                handleErrors(err, element);
            } 
        }
    }

    function handleRequest(data, targetUrl, id){
        const reqMethod = (id) ? "PUT" : "POST";
        return new Promise( (resolve,reject) => {
            axios({
                method: reqMethod,
                url: targetUrl,
                data: data
            })
            .then((response)=>{
                resolve(response);
            })
            .catch((error) => {
                 reject(error.response);
            });
        });    
    }

    function handleErrors(response, element){
        if(response.status == 422){
            displayErrors(response.data.errors, element);
        }else if(response.status == 401 || response.status == 403){
            
            toastr.error(response.data.message);
        }else{
            toastr.error("Sorry, there was an error. Please try again.");
        }
    }

    function displayErrors(err, element){
        $('.fm-error').remove();
        for (let [key, value] of Object.entries(err)) {
            $(element).find(`#${key}`).parent().append(`<span class="fm-error">${value}</span>`)
        }
    }
    //Returns false if data is valid
    //Returns errors object if data is invalid
    function validationErrors(data){
        const errors = {};
        if(data.rating == "" || data.review == null){
            errors.rating = "Rating is required";
        }else if(parseInt(data.rating) < 1 || parseInt(data.rating) > 5){
            errors.rating = "Rating must be a number between 1 and 5";
        }
        if(!data.review || data.review == "" || data.review == null){
            errors.review = "Review is required"
        }
        if(Object.entries(errors).length == 0){
            return false;
        }
        return errors;
    }
})();