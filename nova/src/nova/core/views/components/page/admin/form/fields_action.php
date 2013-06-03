<?php

function field($obj, $property, $default = false)
{
	if (is_object($obj))
	{
		return $obj->{$property};
	}

	return $default;
}

?>

<?php if (is_numeric(Uri::segment(5))): ?>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.back', lang('fields')));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>
<?php endif;?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#general" data-toggle="tab"><?php echo ucwords(langConcat('general attributes'));?></a></li>
	<li><a href="#html" data-toggle="tab"><?php echo ucwords(langConcat('html attributes'));?></a></li>
	<li<?php if (field($field, 'type') != 'select' or Uri::segment(5) == 0){ echo ' class="hide"';}?>><a href="#values" data-toggle="tab"><?php echo ucfirst(lang('values'));?></a></li>
</ul>

<form method="post" action="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>">
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('type'));?></label>
				<div class="controls">
					<?php echo Form::select('type', field($field, 'type'), $types, array('class' => 'span3'));?>
					<p class="help-block help-values hide"><?php echo lang('short.forms.valueCreation');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('restrictions'));?></label>
				<div class="controls">
					<?php echo Form::select('restriction', field($field, 'restriction'), $roles, array('class' => 'span3'));?>
					<p class="help-block"><?php echo lang('short.forms.fieldRestriction');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('label'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'label', 'value' => field($field, 'label'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo ucwords(lang('inline_help'));?></label>
				<div class="controls">
					<?php echo Form::textarea(array('name' => 'help', 'value' => field($field, 'help'), 'class' => 'span6'));?>
				</div>
			</div>

			<?php if (count($sections) > 0): ?>
				<div class="control-group">
					<label class="control-label"><?php echo ucfirst(lang('section'));?></label>
					<div class="controls">
						<?php echo Form::select('section_id', field($field, 'section_id'), $sections, array('class' => 'span3'));?>
					</div>
				</div>
			<?php endif;?>

			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('order'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'order', 'value' => field($field, 'order'), 'class' => 'span1'));?>
					<p class="help-block"><?php echo lang('short.forms.order');?></p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('display'));?></label>
				<div class="controls">
					<?php if (Uri::segment(5) == 0): ?>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::ACTIVE;?>" checked="checked"> <?php echo ucfirst(lang('yes'));?>
						</label>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::INACTIVE;?>"> <?php echo ucfirst(lang('no'));?>
						</label>
					<?php else: ?>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::ACTIVE;?>"<?php if ( (int) field($field, 'status') === Status::ACTIVE){ echo ' checked="checked"';}?>>
							<?php echo ucfirst(lang('yes'));?>
						</label>
						<label class="radio inline">
							<input type="radio" name="status" value="<?php echo Status::INACTIVE;?>"<?php if ( (int) field($field, 'status') === Status::INACTIVE){ echo ' checked="checked"';}?>>
							<?php echo ucfirst(lang('no'));?>
						</label>
					<?php endif;?>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="html">
			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_name', 'value' => field($field, 'html_name'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('id');?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_id', 'value' => field($field, 'html_id'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo ucfirst(lang('class'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_class', 'value' => field($field, 'html_class'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-placeholder">
				<label class="control-label"><?php echo ucfirst(lang('placeholder'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'placeholder', 'value' => field($field, 'placeholder'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-value">
				<label class="control-label"><?php echo ucfirst(lang('value'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'value', 'value' => field($field, 'value'), 'class' => 'span3'));?>
				</div>
			</div>

			<div class="control-group field-rows hide">
				<label class="control-label"><?php echo ucfirst(lang('rows'));?></label>
				<div class="controls">
					<?php echo Form::input(array('name' => 'html_rows', 'value' => field($field, 'html_rows'), 'class' => 'span1'));?>
				</div>
			</div>
		</div>
		
		<?php if (Uri::segment(5) > 0): ?>
			<div class="tab-pane" id="values">
				<div class="row">
					<div class="span6">
						<div class="controls">
							<div class="input-append">
								<input name="value-add-content" type="text" placeholder="<?php echo ucwords(lang('short.add', langConcat('field values')));?>" class="span3"><button class="btn icn16 tooltip-top value-action" data-action="add" title="<?php echo ucfirst(lang('short.add', lang('value')));?>"><div class="icn icn-50" data-icon="+"></div></button>
							</div>
						</div>

						<table class="table table-bordered sort-value">
							<thead>
								<tr>
									<th><?php echo ucfirst(lang('content'));?></th>
									<th><?php echo ucfirst(lang('actions'));?></th>
									<th></th>
								</tr>
							</thead>
							<tbody class="sort-body">
							<?php if (count($values) == 0): ?>
								<tr>
									<td colspan="3">
										<strong class="muted"><?php echo lang('error.notFound', langConcat('field values'));?></strong>
									</td>
								</tr>
							<?php else: ?>
								<?php foreach ($values as $v): ?>
									<tr id="value_<?php echo $v->id;?>">
										<td><?php echo $v->content;?></td>
										<td class="span2">
											<div class="btn-toolbar">
												<div class="btn-group">
													<a href="#" class="btn btn-small value-action tooltip-top icn16" title="<?php echo ucfirst(lang('action.edit'));?>" data-action="update" data-id="<?php echo $v->id;?>"><div class="icn icn-50" data-icon="p"></div></a>
												</div>

												<div class="btn-group">
													<a href="#" class="btn btn-small btn-danger value-action tooltip-top icn16" title="<?php echo ucfirst(lang('action.delete'));?>" data-action="delete" data-id="<?php echo $v->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
												</div>
											</div>
										</td>
										<td class="span1 reorder"></td>
									</tr>
								<?php endforeach;?>
							<?php endif;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>

	<div class="controls">
		<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>

		<?php if (Uri::segment(5) == 0): ?>
			<button class="btn next-tab"><?php echo ucfirst(lang('next'));?></button>
		<?php endif;?>
	</div>

	<?php echo Form::hidden('action', $action);?>
	<?php echo Form::hidden('form_key', Uri::segment(4));?>
	<?php echo Form::hidden('id', Uri::segment(5));?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>