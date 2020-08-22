(function () {
  wp.customize('header_background_color', function (value) {
    value.bind(function (to) {
      const root = document.documentElement;
      root.style.setProperty('--header-bg-color', to);
    });
  });

  wp.customize('footer_background_color', function (value) {
    value.bind(function (to) {
      const footer = document.querySelector('footer');
      if (footer) {
        footer.style.setProperty('--footer-bg-color', to);
      }
    });
  });

  wp.customize('footer_text_color', function (value) {
    value.bind(function (to) {
      const footer = document.querySelector('footer');
      if (footer) {
        footer.style.setProperty('--footer-text-color', to);
      }
    });
  });
})();
