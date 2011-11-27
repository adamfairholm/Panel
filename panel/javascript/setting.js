function slugify(str){return str.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');}

$('#setting_label').keyup(function() {

	$('#setting_name').val(slugify($('#setting_label').val()));

});

$('#setting_type').change(function() {

	var setting_type = document.getElementById("setting_type").value;
	var setting_id = $('#pass_setting_id').val();

	// Extra Parameters

	jQuery.ajax({
		dataType: "text",
		type: "POST",
		data: { XID:EE.XID, type:setting_type },
		url:  EE.BASE+"&C=addons_modules&M=show_module_cp&module=panel&method=show_parameters&setting_id="+setting_id,
		success: function(returned_html){
			$('.panel_extra_param').remove();
			$('#setting_settings_table').append(returned_html);
		}
	});
	
	// Default Value

	jQuery.ajax({
		dataType: "text",
		type: "POST",
		data: { XID:EE.XID, type:setting_type },
		url: EE.BASE+"&C=addons_modules&M=show_module_cp&module=panel&method=show_default_value&setting_id="+setting_id,
		success: function(returned_html){
			$('#default_value_input').html(returned_html);
		}
	});

});
