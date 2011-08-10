<?php if( $settings ): ?>

<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		'Setting', 'Setting Type','Setting Syntax', 'Delete'
	);

	foreach($settings as $setting)
	{
		$type = $setting->setting_type;
	
		$this->table->add_row(
				'<strong><a href="'.$module_base.AMP.'method=edit_setting'.AMP.'panel_id='.$panel_id.AMP.'setting_id='.$setting->id.'">'.$setting->setting_label.'</a><strong>',
				$types->$type->lang['setting_label'],
				'{'.$setting->setting_name.'}',
				'<a href="'.$module_base.AMP.'method=delete_setting'.AMP.'setting_id='.$setting->id.AMP.'panel_id='.$panel_id.'">Delete</a>'
			);
	}
?>
<?php echo $this->table->generate();?>

<?php else: ?>

	<p><?php echo lang('panel_no_settings');?> <a href="<?php echo $module_base.AMP;?>method=new_setting<?php echo AMP;?>panel_id=<?php echo $panel_id;?>"><?php echo lang('panel_create_one');?></a><?php echo lang('panel_question_end');?></p>

<?php endif; ?>