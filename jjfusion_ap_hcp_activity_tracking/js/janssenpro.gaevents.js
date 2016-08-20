/**
 * @file
 * Code for the jjfusion_ap_hcp_activity_tracking.
 */

(function ($) {
  function ga_track(category, action, label) {
    ga('send', 'event', category, action, label, {
      'dimension1': Drupal.settings.user.accId,
      'dimension2': Drupal.settings.user.therapyArea,
      'dimension3': Drupal.settings.user.userRole
    });
  }

  $(document).ready(function () {
    $('.product_pi_link , .product, .view-products a.download').click(function () {
      ga_track('PRODUCT', 'PI DOWNLOAD', $(this).attr('href'));
      var file_name = $(this).attr('href').split('/').pop();
      var d = new Date();
      $.post('/tracking_details', {
        x: 'PI',
        y: file_name,
        l: d.getDate()
      });
    });
    $('.product_cmi_link').click(function () {
      ga_track('PRODUCT', 'CMI DOWNLOAD', $(this).attr('href'));
      var file_name = $(this).attr('href').split('/').pop();
      var d = new Date();
      $.post('/tracking_details', {
        x: 'CMI',
        y: file_name,
        l: d.getDate()
      });
    });

    $('.your-news .full-width-image .btn').click(function () {
      ga_track('HOME', 'Your News - Full Story', $(this).attr('data-title'));
    });
    $('.other-news .full-width-image .btn').click(function () {
      ga_track('HOME', 'Other News - Full Story', $(this).attr('data-title'));
    });
    $('.related-news .full-width-image .btn').click(function () {
      ga_track('HOME', 'Related News - Full Story', $(this).attr('data-title'));
    });
    $('.other-news .more-news').click(function () {
      ga_track('HOME', 'News Items', 'MORE NEWS STORIES');
    });

    $('.product-single .related-patient-resources ul li a').click(function () {
      ga_track('PRODUCT', 'Related Patient Resources', $(this).text());
    });
    $('.product-single .advert a').click(function () {
      ga_track('PRODUCT', 'Promo Tile', $(this).attr('href'));
    });
    $('.product-single .product-faqs ul li a').click(function () {
      ga_track('PRODUCT', 'FAQ', $(this).text());
    });
    $('#product-enquiry-form').submit(function () {
      ga_track('PRODUCT', 'PRODUCT-DETAIL', 'Submit an enquiry');
    });
    var patientButton = $('.patient-resources .action input[type="submit"]');
    patientButton.click(function () {
      var condition_length = $('.patient-resources .conditions input[type="checkbox"]:checked').length;
      var product_length = $('.patient-resources .products input[type="checkbox"]:checked').length;
      if (condition_length > 0 && product_length === 0) {
        ga_track('PATIENT RESOURCES', 'Select Condition(s)', 'VIEW RESOURCES');
      }
      if (condition_length === 0 && product_length > 0) {
        ga_track('PATIENT RESOURCES', 'Select product(s)', 'VIEW RESOURCES');
      }
      if (condition_length > 0 && product_length > 0) {
        ga_track('PATIENT RESOURCES', 'Select Condition(s) product(s)', 'VIEW RESOURCES');
      }
    });
    $('.patient-resources-details .related-patient-resources ul li a').click(function () {
      ga_track('PATIENT RESOURCES', 'Related Patient Resources', $(this).children('.resource-title').text());
      var file_name = $(this).children('.resource-title').text();
      var d = new Date();
      $.post('/tracking_details', {
        x: 'Patient resources',
        y: file_name,
        l: d.getDate()
      });
    });
    $('.related-patient-resources div ul li a').click(function () {
      ga_track('PATIENT RESOURCES', 'Related Patient Resources', $(this).text());
      var file_name = $(this).text();
      var d = new Date();
      $.post('/tracking_details', {
        x: 'Patient resources',
        y: file_name,
        l: d.getDate()
      });
    });

    $('.view-industry-events a.more-info').click(function () {
      var file_name = $(this).attr('href');
      var d = new Date();
      $.post('/tracking_details', {
        x: 'Industry Events',
        y: file_name,
        l: d.getDate()
      });
    });

    $('.patient-resources-details .action .controls .print-btn').click(function () {
      ga_track('PATIENT RESOURCES', 'Related Patient Resources', 'PRINT');
    });
    $('.patient-resources-details .action .controls .email-btn').click(function () {
      ga_track('PATIENT RESOURCES', 'Related Patient Resources', 'EMAIL');
    });
    $('.genric-attachments a').click(function () {
      ga_track($(this).parents('.genric-attachments').attr('data-title'), 'asset', $(this).text());
    });
    $('#enquiry-form').submit(function () {
      ga_track('Request a clinical paper', 'Submit Form', $('#edit-request-clinical-paper').value());
    });
    if ($('.reporting-period').length) {
      var d = new Date();
      $.post('/tracking_details', {
        x: 'JanssenPRO Transparency report Accessed',
        y: 'JanssenPRO Transparency report Accessed',
        l: d.getDate()
      });
    }
  });

})(jQuery);
