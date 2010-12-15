<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=delete_setting'.AMP.'setting_id='.$setting_id.AMP.'panel_id='.$panel_id)?>
	<?=form_hidden('delete_confirm', TRUE)?>
	<?=form_hidden('panel_id', $panel_id)?>
	<p><?=lang('panel_delete_this_setting')?> <strong><?=$setting_label?></strong></p>
	<p><strong class="notice"><?=lang('action_can_not_be_undone')?></strong></p>
	<p><?=form_submit('panel', lang('yes'), 'class="submit"')?></p>
<?=form_close()?>
