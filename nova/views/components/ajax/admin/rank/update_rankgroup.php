<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
		<div class="controls">
			<?php echo Form::input('name', $name, array('class' => 'span4'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('order'));?></label>
		<div class="controls">
			<?php echo Form::input('order', $order, array('class' => 'span1'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('display'));?></label>
		<div class="controls">
			<label class="radio inline"><?php echo ucfirst(lang('on'));?> <?php echo Form::radio('status', Status::ACTIVE, $status);?></label>
			<label class="radio inline"><?php echo ucfirst(lang('off'));?> <?php echo Form::radio('status', Status::INACTIVE, $status);?></label>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'update');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>