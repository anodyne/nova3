<form class="ajax" method="post" action="<?php echo Uri::create('ajax/update/formfield_value/'.$id);?>">
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('content'));?></label>
		<div class="controls">
			<?php echo Form::input('content', $content, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.valuesContent');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('value'));?></label>
		<div class="controls">
			<?php echo Form::input('value', $value, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.valuesValue');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('field'));?></label>
		<div class="controls">
			<?php echo Form::select('field_id', $field, $fields, array('class' => 'span3'));?>
			<p class="help-block"><?php echo lang('short.forms.valuesDropdownOnly');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('order'));?></label>
		<div class="controls">
			<?php echo Form::input('order', $order, array('class' => 'span1'));?>
			<p class="help-block"><?php echo lang('short.forms.order');?></p>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>