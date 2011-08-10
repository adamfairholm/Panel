<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=delete_setting'.AMP.'setting_id='.$setting_id.AMP.'panel_id='.$panel_id)?>
	<?php echo form_hidden('delete_confirm', TRUE)?>
	<?php echo form_hidden('panel_id', $panel_id)?>
	<p><?php echo lang('panel_delete_this_setting')?> <strong><?php echo $setting_label?></strong></p>
	<p><strong class="notice"><?php echo lang('action_can_not_be_undone')?></strong></p>
	<p><?php echo form_submit('panel', lang('yes'), 'class="submit"')?></p>
<?php echo form_close()?>
