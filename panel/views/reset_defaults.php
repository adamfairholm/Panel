<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=reset_defaults');?>
	<?php echo form_hidden('reset_confirm', TRUE)?>
	<p><?php echo lang('panel_reset_settings_msg')?></p>
	<p><strong class="notice"><?php echo lang('action_can_not_be_undone')?></strong></p>
	<p><?php echo form_submit('panel', lang('yes'), 'class="submit"')?></p>
<?php echo form_close()?>
