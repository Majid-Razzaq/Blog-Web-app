
$(document).ready(function(){
    $('.services-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow:"<a href='javscript:void(0);' type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></a>",
        nextArrow:"<a href='javscript:void(0);' type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></a>",
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });
});

  