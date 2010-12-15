<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		'Setting', 'Setting Type','Setting Syntax', 'Delete'
	);

	foreach($settings as $setting)
	{
		$this->table->add_row(
				'<strong><a href="'.$module_base.AMP.'method=new_setting'.AMP.'panel_id='.$panel_id.'">'.$setting->setting_label.'</a><strong>',
				$setting->setting_type,
				'{'.$setting->setting_name.'}',
				'<a href="'.$module_base.AMP.'method=delete_panel'.AMP.'setting_id='.$setting->id.'">Delete</a>'
			);
	}
?>
<?=$this->table->generate();?>