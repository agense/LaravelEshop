$('.edit-btn').each(function(index, element){
    $(element).on('click', function(e){
        let holder = $(e.target).closest("div.review-box");
       $(holder).find("div.review-content").toggleClass('hide');
       $(holder).find('.review-form').toggleClass('hide');
    })
});