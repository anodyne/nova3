<p class="alert alert-danger hide">Field created failed</p>

<p class="alert alert-success hide">Field created</p>

<div class="controls">
	<label class="control-label">Database Table</label>
	<?php echo Form::select('table_name', null, $options);?>
	<p class="help-block">Which database table do you want your field in?</p>
</div>

<div class="controls">
	<label class="control-label">Field Name</label>
	<?php echo Form::input('field_name');?>
	<p class="help-block">What do you want your field to be called?</p>
</div>

<div class="controls">
	<label class="control-label">Field Type</label>
	<?php echo Form::select('field_type', null, $fieldtypes);?>
	<p class="help-block">What kind of data is going to go into the field?</p>
</div>

<div class="controls">
	<label class="control-label">Field Constraint</label>
	<?php echo Form::input('field_constraint');?>
	<p class="help-block">What's the constraint for this field?</p>
</div>

<div class="controls">
	<label class="control-label">Field Default Value</label>
	<?php echo Form::input('field_default');?>
	<p class="help-block">What do you want the default value of this field to be?</p>
</div>