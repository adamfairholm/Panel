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
<?=$this->table->generate();?>

<?php else: ?>

	<p><?=lang('panel_no_settings');?> <a href="<?=$module_base.AMP;?>method=new_setting<?=AMP;?>panel_id=<?=$panel_id;?>"><?=lang('panel_create_one');?></a><?=lang('panel_question_end');?></p>

<?php endif; ?>