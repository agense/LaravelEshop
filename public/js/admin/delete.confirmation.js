const  deletes = $('.item-delete-form');
$(deletes).each(function(index, element){
   $(element).on('submit', function(e){
        e.preventDefault();
        const conf = $(element).find('.confirmation-details');
        const item = $(conf).attr('data-item');
        const txt = $(conf).attr('data-text');
        deleteConfirm(element, item, txt)

    })
})
function deleteConfirm(form, item, txt){
    const title = `Delete this ${ item ? item : 'record'}?`;
    if(window.Swal){
        Swal.fire({
            title: title,
            text: txt ? txt : "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            buttonsStyling: false,
            }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })
    }else{
        return window.confirm(title);
    }  
}