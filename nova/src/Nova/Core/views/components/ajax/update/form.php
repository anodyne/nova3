<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
		<div class="controls">
			<?php echo Form::input('name', $name, array('class' => 'span3'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('orientation'));?></label>
		<div class="controls">
			<?php echo Form::select('orientation', $orientation, $values, array('class' => 'span3'));?>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>