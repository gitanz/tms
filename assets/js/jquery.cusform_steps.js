(function($) {
  $.fn.formSteps = function(options) {
    options = $.extend({  
        editMode: false,
        legendHide: false
    }, options);

    var element = this;
 
    if (options.legendHide == true)
      $(element).find('legend').hide(); 
    if ($('#errorExplanation').length > 0)
      return 

    var steps = $(element).find("fieldset");
    var count = steps.size();
    var advanced = false

    $(element).before("<ul id='form_steps'></ul>");
    $(element).append("<div id='form_steps_commands'><a href='#' data-step='0' id='form_steps_previous' class='form_step_click'>Previous</a> <a href='#' data-step='1' id='form_steps_next' class='form_step_click'>Next</a></div>");

    steps.each(function(i) {
      var name = $(this).find("legend").html();
      if ($(this).hasClass('advanced') == true) {
        advanced = true
        count = count - 1
      }
      else {
        var step_html = "<li id='form_step_" + i + "'>"
        if (options.editMode == true) {
          step_html = step_html + "<a href='#' class='form_step_click' data-step='" + i + "'>Step " + (i + 1) + "</a> "; 
        }
        else {
          step_html = step_html + "Step " + (i + 1) + " ";           
        }
        step_html = step_html + "<span>" + name + "</span></li>";
        $("#form_steps").append(step_html);
      }
    });

    if (advanced == true) {
      $(element).find('input:submit').before("<a href='#' id='form_steps_advanced'>Advanced</a>")
      $('#form_steps_advanced').hide()
    }

    step_display(0);

    $('.form_step_click').on('click',function(event){
      var step = $(this).data('step')
      step_display(step);
      return false;
    });
    $('#form_steps_advanced').on('click',function(event){
      $(element).find('.advanced').show()
      return false;
    });


    function step_display(i) {
      $(element).find('fieldset').hide();
      $(element).find('fieldset').eq(i).show();

      $('.form_step_active').removeClass('form_step_active')
      $('#form_step_' + i).addClass('form_step_active')

      if (i == count-1) {
        $('#form_steps_next').hide().data('step', count);
        $(element).find('input:submit').show();
        $('#form_steps_advanced').show();
      }
      else {
        $('#form_steps_next').show().data('step', (i+1));
        if (options.editMode == false) { $(element).find('input:submit').hide(); }
        $('#form_steps_advanced').hide();
      }

      if (i > 0) {
        $('#form_steps_previous').show().data('step', (i-1));
      }
      else {
        $('#form_steps_previous').hide().data('step', 0);
      }

    }

  }
})(jQuery); 
