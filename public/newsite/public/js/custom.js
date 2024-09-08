$(document).ready(function() {
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    items: 6,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 1500,
    autoplayHoverPause: true
  });
})