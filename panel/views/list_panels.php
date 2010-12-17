<?php if( $panels ): ?>

<?php
	$this->table->set_template($cp_table_template);
	$this->table->set_heading(
		'Panel Name', 'Settings', 'Delete'
	);

	foreach($panels as $panel)
	{
		$this->table->add_row(
				'<strong><a href="'.$module_base.AMP.'method=edit_panel'.AMP.'panel_id='.$panel->id.'">'.$panel->panel_name.'</a><strong>',
				'('.$this->settings_mdl->count_panel_settings($panel->id).') <a href="'.$module_base.AMP.'method=manage_settings'.AMP.'panel_id='.$panel->id.'">Add/Edit Settings</a>',
				'<a href="'.$module_base.AMP.'method=delete_panel'.AMP.'panel_id='.$panel->id.'">Delete</a>'
			);
	}
?>
<?=$this->table->generate();?>

<?php else: ?>

	<p><?=lang('panel_no_panels');?> <a href="<?=$module_base.AMP;?>method=new_panel"><?=lang('panel_create_one');?></a><?=lang('panel_question_end');?></p>

<?php endif; ?>