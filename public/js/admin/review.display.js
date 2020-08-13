(function(){ 
    const showSelectors = document.querySelectorAll('.displayer');
    Array.from(showSelectors).forEach(function(element){
        element.addEventListener('click', function(e){
          const targ = (e.target.classList.contains('displayer')) ? e.target : e.target.parentElement;
          let targetUrl= targ.getAttribute('data-url');
          getReview(targetUrl);
        });
    });

    function getReview(targetUrl){
      axios.get(targetUrl)
      .then(function(response){
          buildDisplay(response.data.data);
          $('#reviewsModal').modal('show');
      })
      .catch(function (error) {
        toastr.error('Sorry,there was an error.');
      });
    }

    function displayStars(rating){
      let stars = '<span class="star-rating">';
      for(i = 1; i <= rating; i++){
        stars += '<span><i class="fi fi-star-full"></i></span>';
      }
      stars += '</span>';
      return stars;
    }

    function buildDisplay(data){
        $('#review-product').html(data.brand+ ' | '+data.product);
        $('.review-holder').html('<div></div>');
        $('.review-holder').append('<div>'+ displayStars(data.rating) +'</div>');
        $('.review-holder').append('<div class="reviewer">Review By: <span id="review-customer">'+ data.user +'</span></div>');
        $('.review-holder').append('<div class="separator-narrow"></div>');
        $('.review-holder').append('<div id="review-content" class="mt-4">'+ data.review +'</div>');
        if(data.deleted_review == 'true'){
          $('.review-holder').append('<div class="separator-narrow"></div>');
          $('.review-holder').append('<div class="delete-info">Deleted By: '+data.deleted_by +'</div>');
          $('.review-holder').append('<div class="delete-info">Deleted At: '+data.deleted_at +'</div>');
          $('.review-holder').append('<div class="delete-info">Delete Reason: '+data.delete_reason +'</div>');
        }
    }
  })();