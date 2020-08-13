(function(){
    let customFiles = $('.custom-file-input');
    let fileArray = Object.values(customFiles);
    fileArray.forEach(elem => {
        $(elem).on('change', function(){
            $(elem).parent().find('.selected-el').remove();
            let files = Object.values(elem.files);
            files.forEach(element => {
                $(elem).parent().append('<span class="selected-el">'+element.name+'</span>');
            });
        });
    });
})();