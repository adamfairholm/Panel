<?php if ($settings): ?>

<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method=panel'.AMP.'panel_id=1');?>

<table class="mainTable padTable" border="0" cellspacing="0" cellpadding="0">
	
	<thead>
		<tr>
			<th style='width:50%;'><?php echo lang('panel_preference'); ?></th>
			<th><?php echo lang('panel_setting'); ?></th>
		</tr>
	</thead>
	
	<tbody>

	<?php
	
		foreach ($settings as $setting):
		
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
		
		<?php endforeach; ?>
	
	</tbody>
	</table>

<p><?php echo form_submit('submit', lang('panel_update_settings'), 'class="submit"')?> <a href="<?php echo $module_base.AMP;?>method=reset_defaults"><?php echo lang('panel_reset');?></a></p>

<?php echo form_close()?>

<?php else: ?>

<p><?php echo lang('panel_no_panels');?> <a href="<?php echo $module_base.AMP;?>method=new_panel"><?php echo lang('panel_create_one');?></a><?php echo lang('panel_question_end');?></p>

<?php endif; ?>