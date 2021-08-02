/* global jQuery:false */
/* global NELSON_STORAGE:false */

(function() {
	"use strict";

	// Init skin-specific actions on first run
	// Attention! Don't forget to add the class "inited" and check it to prevent re-initialize the elements
	jQuery( document ).on(
		'action.ready_nelson', function() {

			jQuery(".sc_layouts_title_caption").html(function(){
				var text= jQuery(this).html().trim().split(" ");
				var last = text.splice(-1);
				return text.join(" ") + " " + (text.length > 0 ? "<span class='accent'>" + last + "</span> " : last );
			});

			jQuery(".sc_action_item_title span").html(function(){
				var text= jQuery(this).text().trim().split(" ");
				var first = text.shift();
				return (text.length > 0 ? "<span class='accent'>"+ first + "</span> " : first) + text.join(" ");
			});
		}
	);


})();
