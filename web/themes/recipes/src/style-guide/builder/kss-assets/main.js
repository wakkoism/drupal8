(function ($, Rainbow) {
  $(function () {

    var $window = $(window),
      $document = $(document),
      $content = $('.kss-content'),
      $sidebar = $('.kss-sidebar'),
      $kssWrapper = $('.kss-wrapper'),
      $hideSidebarButton = $('.kss-hide-sidebar'),
      $sidebarInner = $('.kss-sidebar-inner'),
      $menu = $('.kss-menu'),
      $childMenu = $('.kss-menu-child'),
      $menuItem = $menu.find('.kss-menu-item'),
      $childMenuItem = $childMenu.find('.kss-menu-item'),
      ref = $menu.data('kss-ref'),
      prevScrollTop;

    // Fix sidebar position
    function fixSidebar() {
      if ($sidebarInner.outerHeight() < $content.outerHeight()) {
        $sidebar.addClass('kss-fixed');
        if ($sidebarInner.outerHeight() > $window.height()) {
          $sidebar.height($window.height());
        }
        else {
          $sidebar.height('auto');
        }
      }
      else {
        $sidebar.removeClass('kss-fixed');
        $sidebar.height('auto');
      }
    }

    $hideSidebarButton.on('click', function() {
      $sidebar.toggleClass('no-sidebar');
      $content.toggleClass('no-sidebar');
      $(this).text(function(i, text) {
        return text === 'Hide Sidebar' ? 'Show Sidebar' : 'Hide Sidebar';
      });
    });

    // Activate current page item
    $menuItem.eq(ref).addClass('kss-active');

    // Append child menu.
    if ($childMenu.length) {
      $childMenu.show().appendTo($menuItem.eq(ref));
    }

    // Fixed sidebar
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
      $window.on('resize', fixSidebar).trigger('resize');
    }

    // Toggle menu JS used by the mobile menu component.
    // These JS classes must be added to both the menu
    // and menu button.
    var $menu = $('.js-menu-toggle');
    var $menuButton = $('.js-menu-toggle-button');

    // Handle menu button clicking
    // This needs jQuery update to run.
    $menuButton.on('click', function (event) {
      var $self = $(this);

      // Toggle classes on menu and menu button.
      $self.toggleClass('site-menu__button--active');

      $self
        .parent()
        .parent()
        .find('.js-menu-toggle')
        .toggleClass('site-menu--expanded');
    });

    // Show markup when the button is clicked.
    $('.js-show-markup').on('click', function () {
      var $self = $(this);

      // Grab the inner html of the next available template tag.
      var markup = $self.next('template').html();

      // Replace the button with the markup.
      $self.replaceWith(markup);

      // Syntax hightlighting with Rainbow.js
      Rainbow.color();
    });

    var $programsKSSPage = $('.kss-article > #kssref-pages:first-child, .kss-article > .kss-depth-2');
    if ($programsKSSPage.length == 1) {
      // Append button to go back to styleguide.
      $('<button class="kss-view-styleguide">Back to Pages</button>')
        .prependTo($kssWrapper)
        .on('click', function(event) {
          window.location.href = "/sites/pe.gatech.edu/themes/custom/gtpe/dist/style-guide/section-pages.html";
        });

      // Hide the sidebar and the button.
      $hideSidebarButton.trigger('click').css('display', 'none');
      $content.css({
        'margin': '0',
        'padding': '0'
      });
      $('#kss-node .kss-wrapper').css({
        'max-width': 'none',
        'margin': '0',
        'padding': '0'
      });
      $('#kss-node .kss-section').css('margin-top', '0');
      $programsKSSPage.find('> .kss-style').css('padding-left', '2rem');
      $('#kss-node .kss-modifier .kss-modifier-example').css('padding', '0');
    }
  });
}(jQuery, Rainbow));
