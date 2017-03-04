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

	var form_fields, odoo_fields;

	var selected_form_type, selected_form, selected_odoo_model;

	$('#pagetitle').text(wp_odoo_form_integrator_admin_add_new.str_page_title);

	if (wp_odoo_form_integrator_admin_add_new['str_odoo_form_title']){
		$('#wp_odoo_form_add_new_id').val(wp_odoo_form_integrator_admin_add_new.str_odoo_form_id);		
		$('#wp_odoo_form_add_new_title').val(wp_odoo_form_integrator_admin_add_new.str_odoo_form_title);
	}else{
		$('#wp_odoo_form_add_new_id').remove();
	}

	$(document).ready(function (){
		jQuery.ajax({
			type:"POST",
			url: ajaxurl,
			data: {
				'action': 'get_form_types'
			},
			success:function(data){
				var json = JSON.parse(data);
                var $el = $("#wp_odoo_form_add_new_form_type");
                $el.append($("<option></option>")
                        .attr("value", '').text(wp_odoo_form_integrator_admin_add_new.str_select_form_type));
                $.each(json, function(value, key) {
                    $el.append($("<option></option>")
                            .attr("value", value).text(key));
                });
				if (wp_odoo_form_integrator_admin_add_new['str_odoo_form_form_type']){
					$('#wp_odoo_form_add_new_form_type').val(wp_odoo_form_integrator_admin_add_new.str_odoo_form_form_type);
					$('#wp_odoo_form_add_new_form_type').trigger("change");
				}
			},
			error: function(param1, param2, param3){
				$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_notice_ajax_failed);
				$("#div_notice").removeClass('hidden');
				$("#div_notice").addClass('notice-error');
			}
		});
		jQuery.ajax({
			type:"POST",
			url: ajaxurl,
			data: {
				'action': 'get_odoo_models'
			},
			success:function(data){
				// console.log(data);
				var json = JSON.parse(data);
				if (!json['status']){
					alert(wp_odoo_form_integrator_admin_add_new.str_unable_fetch_odoo_model);
				}
                var $el = $("#wp_odoo_form_add_new_odoo_model");
                $el.append($("<option></option>")
                        .attr("value", '').text(wp_odoo_form_integrator_admin_add_new.str_select_odoo_model+","));
                $.each(json, function(value, key) {
                    $el.append($("<option></option>")
                            .attr("value", key['model']).text(key['name']+",["+key['model']+']'));
                });

				var spacesToAdd = 5;
				var biggestLength = 0;
				var biggestText;
				$("#wp_odoo_form_add_new_odoo_model option").each(function(){
				var len = $(this).text().length;
				    if(len > biggestLength){
				        biggestLength = len;
				        biggestText  = $(this).text();
				    }
				});
				var padLength = biggestLength + spacesToAdd;
				$("#wp_odoo_form_add_new_odoo_model option").each(function(){
				    var parts = $(this).text().split(',');
				    var strLength = parts[0].length + parts[1].length;
				    if (parts[1]){
					    for(var x=0; x<(padLength-strLength); x++){
					        parts[0] = parts[0]+' '; 
					    }
				    }else{
				    	parts[1] = '';
				    }
				    $(this).text((parts[0]+parts[1]).replace(/ /g, '\u00a0')).text;
				});
				if (wp_odoo_form_integrator_admin_add_new['str_odoo_form_odoo_model']){
					$('#wp_odoo_form_add_new_odoo_model').val(wp_odoo_form_integrator_admin_add_new.str_odoo_form_odoo_model);
					$('#wp_odoo_form_add_new_odoo_model').trigger("change");
				}
			},
			error: function(param1, param2, param3){
				$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_notice_ajax_failed);
				$("#div_notice").removeClass('hidden');
				$("#div_notice").addClass('notice-error');
			}
		});
	});

	$('#wp_odoo_form_add_new_form_type').on('change', function(event) {
		if (selected_form_type && selected_form){
			var txt;
			var r = confirm(wp_odoo_form_integrator_admin_add_new.str_form_type_change_warning);
			if (r !== true) {
				event.preventDefault();
				this.value = selected_form_type;
				return;
			}
            var $el = $("#wp_odoo_form_add_new_plugin_form");
            $el.empty();
            selected_form_type = this.value;
		}
		if (this.value){
			selected_form_type = this.value;
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: {
					'action': 'get_all_forms',
					'module': this.value
				},
				success:function(data){
					// console.log(data);
					var json = JSON.parse(data);
	                var $el = $("#wp_odoo_form_add_new_plugin_form");
	                $el.empty();
	                $el.append($("<option></option>")
	                        .attr("value", '').text(wp_odoo_form_integrator_admin_add_new.str_select_form));
	                $.each(json, function(value, key) {
	                    $el.append($("<option></option>")
	                            .attr("value", value).text(key));
	                });
					if (wp_odoo_form_integrator_admin_add_new['str_odoo_form_form']){
						$('#wp_odoo_form_add_new_plugin_form').val(wp_odoo_form_integrator_admin_add_new.str_odoo_form_form);
						$('#wp_odoo_form_add_new_plugin_form').trigger("change");
					}
				},
				error: function(param1, param2, param3){
					$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_notice_ajax_failed);
					$("#div_notice").removeClass('hidden');
					$("#div_notice").addClass('notice-error');
				}
			});
		}
	});

	$('#wp_odoo_form_add_new_plugin_form').on('change', function(event) {
		if (selected_form){
			var txt;
			var r = confirm(wp_odoo_form_integrator_admin_add_new.str_form_change_warning);
			if (r !== true) {
				event.preventDefault();
				this.value = selected_form;
				return;
			}
		}
		if (this.value){
			selected_form = this.value;
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: {
					'action': 'get_form_fields',
					'module': $('#wp_odoo_form_add_new_form_type').val(),
					'form_id': this.value
				},
				success:function(data){
					// console.log(data);
					form_fields = JSON.parse(data);
					if (odoo_fields){
						$.each(odoo_fields, function(key, obj) {
							if (form_fields){
		    					$("#"+key).show();
								$("#"+key).empty();
				                var $el = $("#"+key);
				                $el.append($("<option></option>")
				                        .attr("value", '').text(wp_odoo_form_integrator_admin_add_new.str_select_form));
				                $.each(form_fields, function(value, key) {
				                    $el.append($("<option></option>")
				                            .attr("value", value).text(key));
				                });
							}
						});
					}
				},
				error: function(param1, param2, param3){
					console.log(param1);
					console.log(param2);
					console.log(param3);
				}
			});
		}else{
			if (odoo_fields){
				$.each(odoo_fields, function(key, obj) {
					$("#"+key).empty();
					$("#"+key).hide();
				});
			}
		}
	});

	$('#wp_odoo_form_add_new_odoo_model').on('change', function() {
		if (selected_odoo_model && selected_form){
			var txt;
			var r = confirm(wp_odoo_form_integrator_admin_add_new.str_odoo_model_change_warning);
			if (r !== true) {
				event.preventDefault();
				this.value = selected_odoo_model;
				return;
			}
			$("#wp_odoo_form_add_new_mapping_table > tbody").html("");
		}
		if (this.value){
            selected_odoo_model = this.value;
			jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: {
					'action': 'get_odoo_fields',
					'module': $('#wp_odoo_form_add_new_odoo_model').val(),
					'form_id': this.value
				},
				success:function(data){
					// console.log(data);
					odoo_fields = JSON.parse(data);
					$("#wp_odoo_form_add_new_mapping_table > tbody").html("");

					$.each(odoo_fields, function(key, obj) {
						$('#wp_odoo_form_add_new_mapping_table tbody')
							.append('<tr>' +
										'<td class="row-title">' +
											'<label for="tablecell">'+obj.string+'</label>' +
										'</td>' +
										'<td>' +
											'<label for="tablecell"><code>'+key+'</code></label>' +
										'</td>' +
										'<td>' +
											'<label for="tablecell"><code>'+obj.type+'</code></label>' +
										'</td>' +
										'<td>' +
											'<label for="tablecell">'+((obj.required)?'<mark> required <mark>':'optional')+'</label>' +
										'</td>' +
										'<td>' +
											'<select name="'+key+'" id="'+key+'" class="small-text"></select>' +
										'</td>' +
									'</tr>');
						if (form_fields){
			                var $el = $("#"+key);
			                $el.append($("<option></option>")
			                        .attr("value", '').text(wp_odoo_form_integrator_admin_add_new.str_select_form));
			                $.each(form_fields, function(value, key) {
			                    $el.append($("<option></option>")
			                            .attr("value", value).text(key));
			                });
						}
						if ($("#"+key+" option[value!='']").length == 0) {
	    					$("#"+key).hide();
						}
					});
					if (form_fields && wp_odoo_form_integrator_admin_add_new['str_odoo_form_odoo_mapped_fields']){
		                $.each(wp_odoo_form_integrator_admin_add_new.str_odoo_form_odoo_mapped_fields, function(value, key) {
		                	if (key['form_field']){
			                	$("#"+key['odoo_field']).val(key['form_field']);
		                	}
		                });
					}
				},
				error: function(param1, param2, param3){
					console.log('error');
					console.log(param1);
					console.log(param2);
					console.log(param3);
				}
			});
		}
	});

	$("#wp_odoo_form_add_new_submit").click(function(){
		if(validate()){
			$("#wp_odoo_form_add_new_form").submit();
		}
	});

	function validate() {
		$("#div_notice").addClass('hidden');
		var error_found;
		var error_field;
		if(!$("#wp_odoo_form_add_new_title").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_error_mapping_title);
			error_found = true;
			error_field = "wp_odoo_form_add_new_title";
		}else if(!$("#wp_odoo_form_add_new_form_type").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_error_mapping_form_type);
			error_found = true;
			error_field = "wp_odoo_form_add_new_form_type";
		}else if(!$("#wp_odoo_form_add_new_plugin_form").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_error_mapping_form);
			error_found = true;
			error_field = "wp_odoo_form_add_new_plugin_form";
		}else if(!$("#wp_odoo_form_add_new_odoo_model").val()){
			$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_error_mapping_model);
			error_found = true;
			error_field = "wp_odoo_form_add_new_odoo_model";
		}
		if (!error_found){
			$.each(odoo_fields, function(key, obj) {
				console.log($("#"+key).val());
				if($("#"+key).val()){
					error_found = false;
					return false;
				}
				$("#p_notice").text(wp_odoo_form_integrator_admin_add_new.str_error_mapping_no_fields);
				error_found = true;
				error_field = "wp_odoo_form_add_new_odoo_model";
			});
		}
		if(error_found){
			$("#div_notice").removeClass('hidden');
			$("#div_notice").addClass('notice-error');
			$("#"+error_field).focus();
			return false;
		}
		return true;
    }

	$(document).on({
	    ajaxSend: function(event, request, settings) {
	    	if (settings['data']){
	    		if (settings['data'].match('action=get_form_types')  ||
	    			settings['data'].match('action=get_odoo_models') ||
	    			settings['data'].match('action=get_form_types')  ||
	    			settings['data'].match('action=get_all_forms')   ||
	    			settings['data'].match('action=get_odoo_fields') ||
	    			settings['data'].match('action=get_form_fields')){
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

