<p><?php echo lang('short.deleteConfirm', lang('section'), $name);?></p>

<form method="post">
	<?php if (count($sections) > 0): ?>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<?php echo Form::select('new_section_id', false, $sections, array('class' => 'span3'));?>
				<p class="help-block"><?php echo lang('short.forms.sectionUpdateFields', $name);?></p>
			</div>
		</div>
	<?php else: ?>
		<?php echo Form::hidden('new_section_id', 0);?>
	<?php endif;?>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'delete');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>