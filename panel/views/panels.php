<?php if( $panels ): ?>

<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel');?>

<?php foreach( $panels as $panel_id => $settings ): ?>

<table class="mainTable padTable" border="0" cellspacing="0" cellpadding="0">

	<caption><?php echo $panel_info[$panel_id]['name']; ?></caption>
	
	<thead class="visualEscapism">
		<tr>
			<th><?php echo lang('panel_preference'); ?></th>
			<th><?php echo lang('panel_setting'); ?></th>
		</tr>
	</thead>
	
	<tbody>

	<?php
	
		if( $settings ):
		
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
				
			endif; ?>
			
			<tr class="even">
				<td width="200"><?php echo $label; ?></td>
				<td><?php echo $types->$setting_type->form_output( $setting->setting_name, $setting->value, $setting->data); ?></td>			
			</tr>
		
		<?php endforeach;
		
		else:
		
			echo '<tr><td colspan="2"><em>'.lang('panel_no_settings_msg').'</em></td></tr>';
		
		endif;
		
	?>
	
	</tbody>
	</table>
	
<?php endforeach; ?>

<p><?php echo form_submit('submit', lang('panel_update_settings'), 'class="submit"')?> <a href="<?php echo $module_base.AMP;?>method=reset_defaults"><?php echo lang('panel_reset');?></a></p>

<?php echo form_close()?>

<?php else: ?>

<p><?php echo lang('panel_no_panels');?> <a href="<?php echo $module_base.AMP;?>method=new_panel"><?php echo lang('panel_create_one');?></a><?php echo lang('panel_question_end');?></p>

<?php endif; ?>