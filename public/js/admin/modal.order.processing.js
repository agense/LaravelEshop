function initOrderProcessingModal(modalId, targetUrl){
    //Select the form 
    const formId = modalId.replace('-modal', '-form');
    const fm = $(`#${formId}`)
    //Get initial form data for reseting modal info upon close
    const initData = getFormData(fm);

    //On modal show, attach event listener to modal form submission event
    $(`#${modalId}`).on('show.bs.modal', function (e) {

        $(fm).on('submit', async function(e){
            e.preventDefault();
            //Get the new form data and submit the form
            const data = getFormData(fm);
            try{
                await submitForm(targetUrl,data);
                location.reload(true);
            }catch(err){
                handleErrors(err, fm);
            } 
        });
    });

    // On modal closing, reset initail form data
    $(`#${modalId}`).on("hidden.bs.modal", function(){
        clearModal();
    });

    // Extract data from all form fields and return as object
    function getFormData(fm){
        let data = {};
        let selectors = $('input, select').not(':input[type=file],:input[type=button], :input[type=submit], :input[type=hidden]');
        $(fm).find(selectors).each(function(){
            data[$(this).attr('name')] = $(this).val();
        });
        return data; 
    }

    //Submit modal form and return response as promise
    function submitForm(targetUrl,data){
        return new Promise((resolve, reject)=>{
            axios({ 
                method: 'PUT', 
                url: targetUrl, 
                data: data, 
                config: { headers: {'Content-Type': 'application/json'}}
                })
                .then(function(response){   
                    resolve(response)
                })
                .catch(function (error) {
                    reject(error.response)
                });
        })
    }
    // Handle form errors
    function handleErrors(response, fm){
        if(response.status == 422){
            displayErrors(response.data.errors, fm);
        }else if(response.status == 401 || response.status == 403){
            toastr.error(response.data.message)
        }else{
            toastr.error('Sorry, there was an error.');
        }
    }

    //Display form errors 
    function displayErrors(err, fm){ 
        $('.fm-error').remove();
        for (let [key, value] of Object.entries(err)) {
            $(fm).find(`#${key}`).parent().append(`<span class="fm-error">${value}</span>`)
        }
    }

    // Reset all model forms fields to initial values and remove errors
    function clearModal(){
        $(".fm-error").remove();
        for (let [key, value] of Object.entries(initData)) {
            let field = $(fm).find(`#${key}`);
            if($(field).is('select')){
                resetSelectedField(field, value)
            }else{
                $(field).val(value).change();
            }
        }
    }

    // Reset the select element selected index option to the value specified
    // Arguments: field - select field obj, value - the value of the option which must be set to selected
    function resetSelectedField(field, value){
        $(field).children('option[value="'+ value +'"]').attr("selected", "selected");
        $(field).children('option[value="'+ value +'"]').prop("selected", "selected");
        $(field).val(value).change()
    }
}
