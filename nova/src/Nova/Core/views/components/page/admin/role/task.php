<?php

function task($obj, $property, $default = false)
{
	if (is_object($obj))
	{
		return $obj->{$property};
	}

	return $default;
}

?><div class="btn-group">
	<a href="<?php echo Uri::create('admin/role/tasks');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.back', langConcat('access tasks')));?>"><div class="icn icn-75" data-icon="<"></div></a>
</div>

<form>
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
		<div class="controls">
			<input type="text" name="name" value="<?php echo task($task, 'name');?>" class="span4">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('desc'));?></label>
		<div class="controls">
			<textarea name="desc" class="span8" rows="2"><?php echo task($task, 'desc');?></textarea>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('component'));?></label>
		<div class="controls">
			<input type="text" name="component" value="<?php echo task($task, 'component');?>" class="span2" data-provide="typeahead" data-source='<?php echo $componentSource;?>'>
			<p class="help-block"><?php echo lang('short.roles.chooseTaskComponent');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('action_proper'));?></label>
		<div class="controls">
			<input type="text" name="action" value="<?php echo task($task, 'action');?>" class="span2" data-provide="typeahead" data-source='<?php echo $actionSource;?>'>
			<p class="help-block"><?php echo lang('short.roles.chooseTaskAction');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('level'));?></label>
		<div class="controls">
			<input type="text" name="level" value="<?php echo task($task, 'level');?>" class="span1">
			<p class="help-block"><?php echo lang('short.roles.chooseTaskLevel');?></p>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('dependencies'));?></label>
		<div class="controls">
			<textarea name="dependencies" class="span8" rows="5"><?php echo task($task, 'dependencies');?></textarea>
			<p class="help-block"><?php echo lang('short.roles.chooseTaskDependencies');?></p>
		</div>
	</div>

	<div class="controls">
		<button type="submit" class="btn btn-primary" name="submit"><?php echo ucfirst(lang('action.submit'));?></button>
	</div>

	<?php echo Form::hidden('action', $action);?>
	<?php echo Form::hidden('id', $task->id);?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>