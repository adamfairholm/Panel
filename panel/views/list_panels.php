<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		'Panel Name', 'Settings', 'Delete'
	);

	foreach($panels as $panel)
	{
		$this->table->add_row(
				'<strong><a href="'.$module_base.AMP.'method=edit_panel'.AMP.'panel_id='.$panel->id.'">'.$panel->panel_name.'</a><strong>',
				'(0) <a href="'.$module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel->id.'">Add/Edit Settings</a>',
				'<a href="'.$module_base.AMP.'method=delete_panel'.AMP.'panel_id='.$panel->id.'">Delete</a>'
			);
	}
?>
<?=$this->table->generate();?>