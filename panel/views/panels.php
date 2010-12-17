<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_module', array('id'=>'my_accordion'));?>



<?php
	$this->table->set_template($cp_pad_table_template);
	$this->table->template['thead_open'] = '<thead class="visualEscapism">';
?>

<?php foreach( $panels as $panel_id => $settings ): ?>
			
<div>
	<h3 class="accordion"><?=$panel_info[$panel_id]['name'];?></h3>
	<div>
	
	<?php
	
		$this->table->set_heading('Preference', 'Setting');	
		
		foreach( $settings as $setting ):
		
			$setting_type = $setting->setting_type;
	
			$this->table->add_row($setting->setting_label, $types->$setting_type->form_output( $setting->setting_name, $setting->value, $setting->data ) );
		
		endforeach;

		echo $this->table->generate();

		$this->table->clear();
	?>
	</div>
	
</div>

<?php endforeach; ?>