<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method='.$method.'_panel')?>
	
	<?php if ($id):?>
		<div><?php echo form_hidden('id', $id)?></div>
	<?php endif;?>

	<p>
	<label for="panel_name"><?php echo lang('panel_name')?></label>
	<?php echo form_input(array('id'=>'panel_name','name'=>'panel_name','size'=>80,'class'=>'field','value'=>$panel_name))?>				
	</p>
	
	<p><?php echo form_submit('submit', lang('submit'), 'class="submit"')?></p>

<?php echo form_close()?>