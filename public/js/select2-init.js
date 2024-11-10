"use strict";

// document ready 
$(function () {
    function formatText(icon) {
        return $(
          '<span><i class="' +
            $(icon.element).data("icon") +
            '"></i> ' +
            icon.text +
            "</span>"
        );
      }
      
      // select2 input with icon
      $(".select2-input-image").select2({
        width: "100%",
        marginBottom: "10px",
        templateSelection: formatText,
        templateResult: formatText,
      });

      // select2 input without image 
      $(".select2-input").select2({
        width: "100%",
      });
    
      // select2 style 
      $('.select2.select2-container').css({
        'margin-bottom': '10px',
      })

      $('.select2.select2-selection.select2-selection--single').addClass('ot-input');

      // remove default arrow and add custom arrow start

      $('b[role="presentation"]').hide();
      $('.select2-selection__arrow').append('<i class="las la-angle-down"></i>');

      $('.select2-selection__arrow').css({
        'display': 'flex',
        'align-items': 'center',
        'justify-content': 'center',
      });

            // remove default arrow and add custom arrow end
      
});



