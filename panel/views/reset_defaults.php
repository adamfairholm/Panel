<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=reset_defaults');?>
	<?=form_hidden('reset_confirm', TRUE)?>
	<p><?=lang('panel_reset_settings_msg')?></p>
	<p><strong class="notice"><?=lang('action_can_not_be_undone')?></strong></p>
	<p><?=form_submit('panel', lang('yes'), 'class="submit"')?></p>
<?=form_close()?>
