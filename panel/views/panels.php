<style>
 .pageContents {padding: 0!important;}
 .mainTable tr td a {color: #5f6c74!important; text-decoration: underline!important;}
</style>

<?php if($panels) { ?>

<div class="overview">

<table class="mainTable" border="0" cellspacing="0" cellpadding="0">

	<?php foreach ($panels as $panel) { ?>
	
	<tr class="even">
		<td class="overviewItemName"><a href="<?php echo $module_base.AMP.'method=panel'.AMP.'panel_id='.$panel->id; ?>"><?php echo $panel->panel_name; ?></a></td>
		<td class="overviewItemDesc"><?php echo $panel->panel_desc; ?></td>
	</tr>
	
	<?php } ?>
	
	<tbody>

</table>

<?php } else { ?>

<p><?php echo lang('panel_no_panels');?> <a href="<?php echo $module_base.AMP;?>method=new_panel"><?php echo lang('panel_create_one');?></a><?php echo lang('panel_question_end');?></p>

<?php } ?>