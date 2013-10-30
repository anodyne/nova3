<?php

if ( ! function_exists('ruleData'))
{
	function ruleData($obj, $property, $default = false)
	{
		if (is_object($obj))
		{
			if ($property == 'users.user' or $property == 'users.position')
			{
				// parse the users field
				$data = json_decode($obj->users);

				if ($property == 'users.user' and property_exists($data, 'user'))
				{
					return $data->user;
				}

				if ($property == 'users.position' and property_exists($data, 'position'))
				{
					return $data->position;
				}

				return $default;
			}
			else
			{
				return $obj->{$property};
			}
		}

		return $default;
	}
}

?>
<div class="btn-group">
	<a href="<?php echo Uri::create('admin/application/rules');?>" class="btn icn16 tooltip-top" title="<?php echo lang('short.back', lang('rules'));?>"><div class="icn icn-75" data-icon="<"></div></a>
</div>

<form method="post" action="<?php echo Uri::create('admin/application/rules');?>">
	<div class="form-group">
		<label class="control-label"><?php echo ucfirst(lang('type'));?></label>
		<div class="controls">
			<?php echo Form::select('type', ruleData($rule, 'type'), array('global' => ucfirst(lang('global')), 'dept' => ucfirst(lang('department'))), array('id' => 'ruleType', 'class' => 'chzn span2'));?>
		</div>
	</div>

	<div id="deptRule" class="hidden">
		<div class="form-group">
			<label class="control-label"><?php echo ucfirst(langConcat('department is'));?>...</label>
			<div class="controls">
				<?php echo NovaForm::department('condition', ruleData($rule, 'condition'), array('class' => 'chzn span4'));?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label"><?php echo ucfirst(lang('short.add', lang('users'));?>...</label>
		<div class="controls">
			<?php echo NovaForm::users('users[user]', ruleData($rule, 'users.user'), array('multiple' => 'multiple', 'class' => 'chzn span4'));?>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label"><?php echo ucfirst(lang('short.add', langConcat('users in positions'));?>...</label>
		<div class="controls">
			<?php echo NovaForm::position('users[position]', ruleData($rule, 'users.position'), array('multiple' => 'multiple', 'class' => 'chzn span4'));?>
		</div>
	</div>

	<div class="controls">
		<?php echo Form::hidden('action', $action);?>
		<?php echo Form::hidden('id', Uri::segment(4));?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>

		<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
	</div>
</form>