<?php

	$form_url = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method='.$method.'_setting'.AMP.'panel_id='.$panel_id;
	
	if( $method == 'edit' ):
	
		$form_url .= AMP.'setting_id='.$setting_id;
	
	endif;
	
?>

<?=form_open($form_url)?>

<table class="mainTable padTable" id="setting_settings_table" cellspacing="0" cellpadding="0" border="0">
<thead>
	<tr>
		<th colspan="2">
			Setting Settings
		</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td width="40%">
			<strong><?=lang('panel_setting_type')?></strong> 
		</td>
		<td>
			<?=form_dropdown('setting_type', $setting_types, $setting_type, 'id="setting_type"')?>
		</td>
	</tr>
	<tr>
		<td>
			<em class='required'>* </em><?=form_label(lang('panel_setting_label'), 'setting_label')?><br /><?=lang('panel_setting_label_info')?>
		</td>
		<td>
			<?=form_input(array('id'=>'setting_label','name'=>'setting_label','class'=>'fullfield','value'=>$setting_label))?>
		</td>
	</tr>
	<tr>
		<td>
			<em class='required'>* </em><?=form_label(lang('panel_setting_name'), 'setting_name')?><br /><?=lang('panel_setting_name_info')?>
		</td>
		<td>
			<?=form_input(array('id'=>'setting_name','name'=>'setting_name','class'=>'fullfield','value'=>$setting_name))?>
		</td>
	</tr>
	<tr>
		<td>
			<?=form_label(lang('panel_setting_instr'), 'instructions')?><br /><?=lang('panel_setting_instr_info')?>
		</td>
		<td>
			<?=form_input(array('id'=>'instructions','name'=>'instructions','class'=>'fullfield','value'=>$instructions))?>
		</td>
	</tr>
	<tr>
		<td>
			<?=form_label(lang('panel_setting_default'), 'default_value')?><br /><?=lang('panel_setting_default_info')?>
		</td>
		<td>
			<?=form_input(array('id'=>'default_value','name'=>'default_value','class'=>'fullfield','value'=>$default_value))?>
		</td>
	</tr>
	
	<?=$extra_rows;?>

</tbody>
</table>

<input type="hidden" value="<?=$setting_id;?>" name="pass_setting_id" id="pass_setting_id" />

<p><?=form_submit('submit', lang('submit'), 'class="submit"')?></p>

<?=form_close()?>