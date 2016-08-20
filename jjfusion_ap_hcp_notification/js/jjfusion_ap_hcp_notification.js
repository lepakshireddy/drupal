/**
 * @file
 * Code for the jjfusion_ap_hcp_notification.
 */

(function ($) {
  'use strict';
  $(document).ready(function () {
    if ($('.notification-block').length > 0) {
      $.ajax({
        type: 'GET',
        url: '/notify_blck',
        success: function (result) {
          $('.notification-block').html(result);
          $('.toolbar ul li.user a span').text($('.user-inner .notifications').attr('data-count'));
        }
      });
    }
    $('.notifications li').live('click', function () {
      var ext_url = $('.notifications li h3 a').attr('href');
      var dataString = $(this).attr('id');
      $.ajax({
        type: 'POST',
        url: '/notify_details',
        async: false,
        data: {id: dataString}
      });

      // Some ajax here to mark item as read and or open the link if needed.
      if (!$(this).hasClass('selected')) {
        $(this).addClass('selected');
        if ($(this).hasClass('external')) {
          overlay();
          $('#offsite').slideDown(450);
          $('.back').click(function () {
            $('#offsite').slideUp();
            closeOverlay();
          });
          $('.proceed').click(function () {
            $('.proceed').attr('href', ext_url);
            $('#offsite').slideUp();
            $.ajax({
              type: 'POST',
              url: '/notify_blck',
              async: false,
              data: {id: dataString},
              success: function (data) {
                $('.notification-block').html(data);
                $('.toolbar ul li.user a span').text($('.user-inner .notifications').attr('data-count'));
                $('#header-elements').removeClass('menu-open');
              }
            });
            closeOverlay();
          });
          $('.proceed').attr('href', '#');
          return false;
        }
        var anchor = $(this).children().find('a');
        window.location.href = anchor[0].href;
      }

    });
  });

})(jQuery);
