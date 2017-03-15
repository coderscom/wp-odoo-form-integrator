(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$("#wp_odoo_form_odoo_submit").click(function(){
		if(validate()){
			$("#wp_odoo_form_odoo_properties_form").submit();
		}
	});

	$("#wp_odoo_form_odoo_test").click(function(){
		if(validate()){
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: {
					'action': 'test_odoo_connection',
					'cc_odoo_integrator_odoo_url': $("#cc_odoo_integrator_odoo_url").val(),
					'cc_odoo_integrator_odoo_database': $("#cc_odoo_integrator_odoo_database").val(),
					'cc_odoo_integrator_odoo_username': $("#cc_odoo_integrator_odoo_username").val(),
					'cc_odoo_integrator_odoo_password': $("#cc_odoo_integrator_odoo_password").val()
				},
				success:function(data){
					var res = JSON.parse(data);
					if (res['status']) {
						$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_notice_odoo_connected);
						$("#div_notice").removeClass('hidden');
						$("#div_notice").removeClass('notice-error');
						$("#div_notice").addClass('notice-success');
					}else{
						$("#p_notice").text(res['message']);
						$("#div_notice").removeClass('hidden');
						$("#div_notice").removeClass('notice-success');
						$("#div_notice").addClass('notice-error');
					}
				},
				error: function(param1, param2, param3){
					$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_notice_ajax_failed);
					$("#div_notice").removeClass('hidden');
					$("#div_notice").addClass('notice-error');
				}
			});
		}
	});

	function validate() {
		$("#div_notice").addClass('hidden');
		var error_found;
		var error_field;
		if(!validateURL($("#cc_odoo_integrator_odoo_url").val())){
			$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_error_odoo_url);
			error_found = true;
			error_field = "cc_odoo_integrator_odoo_url";
		}else if(!$("#cc_odoo_integrator_odoo_database").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_error_odoo_database);
			error_found = true;
			error_field = "cc_odoo_integrator_odoo_database";
		}else if(!$("#cc_odoo_integrator_odoo_username").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_error_odoo_username);
			error_found = true;
			error_field = "cc_odoo_integrator_odoo_username";
		}else if(!$("#cc_odoo_integrator_odoo_password").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_settings.str_error_odoo_password);
			error_found = true;
			error_field = "cc_odoo_integrator_odoo_password";
		}
		if(error_found){
			$("#div_notice").removeClass('hidden');
			$("#div_notice").addClass('notice-error');
			$("#"+error_field).focus();
			return false;
		}
		return true;
    }

	function validateURL(textval) {
	  var urlregex = new RegExp("^(http:\/\/|https:\/\/){1}([0-9A-Za-z]+\.)");
	  return urlregex.test(textval);
	}

	$(document).on({
	    ajaxSend: function(event, request, settings) {
	    	if (settings['data']){
	    		if (settings['data'].match('action=test_odoo_connection')){
			    	if (!$('#loading_gif').hasClass("modal")){
			    		$('#loading_gif').addClass("modal");    
			    	}
	    		}
	    	}
	    },
	    ajaxStop: function() {
	    	$('#loading_gif').removeClass("modal"); 
	    }    
	});

})( jQuery );