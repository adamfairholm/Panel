<?=form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=panel'.AMP.'method='.$method.'_panel')?>
	
	<?php if ($id):?>
		<div><?=form_hidden('id', $id)?></div>
	<?php endif;?>

	<p>
	<label for="panel_name"><?=lang('panel_name')?></label>
	<?=form_input(array('id'=>'panel_name','name'=>'panel_name','size'=>80,'class'=>'field','value'=>$panel_name))?>				
	</p>
	
	<p><?=form_submit('submit', lang('submit'), 'class="submit"')?></p>

<?=form_close()?>