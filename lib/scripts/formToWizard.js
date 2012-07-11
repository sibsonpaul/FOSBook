/* Created by jankoatwarpspeed.com */

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({  
            submitButton: "form_submit" 
        }, options); 
        
        var element = this;

        var steps = $(element).find(".form_page");
        var count = steps.size();
        var submmitButtonName = $("#" + options.submitButton).parent('.ui-btn');
        submmitButtonName.hide();

        // 2
        $(element).before("<div id='steps' data-role='controlgroup' data-type='horizontal' data-theme='b'></div>");

        steps.each(function(i) {
            $(this).wrap("<div id='step" + i + "' class='form_content'></div>");
            $(this).append("<div id='step" + i + "commands' class='prev_next'></div>");

            // 2
            var name = $(this).data("name");
			
            $("#steps").append("<a href='#' data-step='"+i+"' id='step"+i+"Link' class='linkButton' data-role='button' data-theme='b' data-inline='true'>" + name + "</a>");

				 $("#step"+i+"Link").bind("click", function(e) {
					var id = $(this).data('step'); 
                $(".form_content").hide();
                $("#step" + id ).show();
               
                selectStep(id);
            });
			
		
			
            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev ui-btn ui-btn-icon-left ui-btn-corner-all ui-shadow ui-btn-up-b' data-inline='true'><span class='ui-btn-inner ui-btn-corner-all' aria-hidden='true'><span class='ui-icon ui-icon-arrow-l ui-icon-shadow'></span><span class='ui-btn-text'>Back</span></span></a>");

            $("#" + stepName + "Prev").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $(submmitButtonName).hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next ui-btn ui-btn-icon-right ui-btn-corner-all ui-shadow ui-btn-up-b' data-inline='true'><span class='ui-btn-inner ui-btn-corner-all' aria-hidden='true'><span class='ui-btn-text'>Next</span><span class='ui-icon ui-icon-arrow-r ui-icon-shadow'></span></span></a>");

            $("#" + stepName + "Next").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i + 1)).show();
                if (i + 2 == count)
                    $(submmitButtonName).show();
                selectStep(i + 1);
            });
        }

        function selectStep(i) {
            $(".linkButton").removeClass("ui-btn-up-b");
			 $(".linkButton").removeClass("ui-btn-up-f");
           $("#step" + i+'Link').addClass("ui-btn-up-f");
			 $(".linkButton").addClass("ui-btn-up-b");
		
        }

    }
})(jQuery); 
