<?php if( $panels ): ?>

<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel', array('id'=>'my_accordion'));?>

<?php
	$this->table->set_template($cp_pad_table_template);
	$this->table->template['thead_open'] = '<thead class="visualEscapism">';
?>

<?php foreach( $panels as $panel_id => $settings ): ?>
			
	<h3 class="accordion"><?=$panel_info[$panel_id]['name'];?></h3>

	<div style="padding: 5px 1px;"> 
	
	<?php
	
		$this->table->set_heading(lang('panel_preference'), lang('panel_setting'));	
		
		foreach( $settings as $setting ):
		
			$setting_type = $setting->setting_type;
			
			if( isset($types->$setting_type->use_label) && $types->$setting_type->use_label ):

				$label = '<strong><label for="'.$setting->setting_name.'">'.$setting->setting_label.'</label></strong>';
			
			else:

				$label = '<strong>'.$setting->setting_label.'</strong>';
			
			endif;
			

			// Add in instructions

			if( $setting->instructions ):
			
				$label .= '<div class="subtext">' . $setting->instructions . '</div>';
				
			endif;
	
			$this->table->add_row($label, $types->$setting_type->form_output( $setting->setting_name, $setting->value, $setting->data ) );
		
		endforeach;

		echo $this->table->generate();

		$this->table->clear();
	?>
	
	</div>
	
<?php endforeach; ?>

<p><?=form_submit('submit', lang('panel_update_settings'), 'class="submit"')?></p>

<?=form_close()?>

<?php else: ?>

<p><?=lang('panel_no_panels');?> <a href="<?=$module_base.AMP;?>method=new_panel"><?=lang('panel_create_one');?></a><?=lang('panel_question_end');?></p>

<?php endif; ?>