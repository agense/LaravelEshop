function initFullSlider(identifier){
    $(`.${identifier}`).slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows:false,
        autoplay: true,
        autoplaySpeed: 3000,
    });
}

function initCarousel(identifier, slidesToShow = 3, slidesToScroll = 1){
    $(`.${identifier}`).slick({
        infinite: true,
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToScroll,
        arrows:true,
        responsive: [
          {
            breakpoint: 996,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
      ] 
    });
}

function initNavigationSlider(identifier, nav){
    $('.product-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        asNavFor: `.${identifier}`
      });
     $('.product-nav-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: `.${nav}`,
        arrows: false,
        focusOnSelect: true
      }); 
}