(function ($) {
  wp.customize('header_background_color', function (value) {
    value.bind(function (to) {
      //$( 'a' ).css( 'color', to );
      $(':root').get(0).style.setProperty('--header-bg-color', to);
    });
  });

  wp.customize('footer_background_color', function (value) {
    value.bind(function (to) {
      //$( 'a' ).css( 'color', to );
      $(':root').get(0).style.setProperty('--footer-bg-color', to);
    });
  });
  wp.customize('footer_text_color', function (value) {
    value.bind(function (to) {
      //$( 'a' ).css( 'color', to );
      $(':root').get(0).style.setProperty('--footer-text-color', to);
    });
  });
})(jQuery);
