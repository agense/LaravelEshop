function initSummernote(identifierId, deletable = false){
    let enableDeletes = {}
    if(deletable == true){
        enableDeletes = {
            onMediaDelete : function(target, editor, editable) { deletePageFile(target);}
        }
    }
    
    $(`#${identifierId}`).summernote({
        callbacks: enableDeletes, 
        toolbar: [               
            ['style', ['style','bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['hr','table','link', 'picture']],
            ['view', ['fullscreen']],
        ],
        fontNames: ['Raleway', 'Open Sans', 'Open Sans Condensed', 'Roboto', 'Arial', 'Arial Black'],
        styleTags: ['p','h1', 'h2', 'h3', 'h4', 'h5', 'h6',{ title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote'}, ],
        height:400,
    });
    
    function deletePageFile(target){
        const baseUrl = $('#page-form').attr('data-target');
        let filepath = target[0].currentSrc;
        // Send ajax request via axios
        axios.post(`${baseUrl}/deletePageImage`, {
            fileurl: filepath
        })
        .then(function(response){
            if(response.status == 200){
                // remove element in editor 
                target.remove();
                toastr.success('File Deleted! Update this page before closing it to prevent errrors.');
            }
        })
        .catch(function(error){
            $(`#${identifierId}`).summernote('undo');
            toastr.error('Error.File delete failed.');
        });
    }
}
function initSummernoteForProductText(){
    $(`#description`).summernote({
        toolbar: [               
            ['style', ['style','bold', 'italic', 'underline', 'clear']],
            ['font', ['superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['hr','link']],
        ],
        styleTags: ['p','h6'],
    });
}