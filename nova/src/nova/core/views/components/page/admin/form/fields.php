<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('all forms'));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4).'/0');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.add', lang('field')));?>"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('tabs')));?>"><?php echo $images['tabs'];?></a>
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('sections')));?>"><?php echo $images['sections'];?></a>
	</div>
</div>

<?php if ($tabs !== false): ?>
	<ul class="nav nav-tabs">
	<?php foreach ($tabs as $t): ?>
		<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?><?php if ($t->status === Status::INACTIVE){ echo ' ('.ucfirst(lang('inactive')).')';}?></a></li>
	<?php endforeach;?>
	</ul>
	
	<div class="tab-content">
	<?php foreach ($tabs as $t): ?>
		<div class="tab-pane" id="<?php echo $t->link_id;?>">
		<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
			<?php foreach ($sections[$t->id] as $s): ?>
				<fieldset>
					<legend><?php echo $s->name;?><?php if ($s->status === Status::INACTIVE){ echo ' <small>'.ucfirst(lang('inactive')).'</small>';}?></legend>

					<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
						<table width="100%" class="table-striped sort-field">
							<tbody class="sort-body">
							<?php foreach ($fields[$s->id] as $f): ?>
								<tr id="field_<?php echo $f->id;?>">
									<td class="span9 control-group">
										<label class="control-label">
											<?php echo $f->label;?>
											<?php if ($f->status === Status::INACTIVE): ?>
												<span class="muted">(<?php echo ucfirst(lang('inactive'));?>)</span>
											<?php endif;?>
										</label>
										<div class="controls">
											<?php if ($f->type == 'text'): ?>
												<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
											<?php elseif ($f->type == 'textarea'): ?>
												<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
											<?php elseif ($f->type == 'select'): ?>
												<?php echo Form::select($f->html_name, $f->value, $f->getValues(), array('class' => $f->html_class, 'id' => $f->html_id));?>
											<?php endif;?>

											<?php if ( ! empty($f->help)): ?>
												<p class="help-block"><?php echo $f->help;?></p>
											<?php endif;?>
										</div>
									</td>
									<td class="span2">
										<div class="btn-toolbar pull-right">
											<div class="btn-group">
												<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-small tooltip-top icn16" title="<?php echo ucfirst(lang('action.edit')).' '.$f->label;?>"><div class="icn icn-50" data-icon="p"></div></a>
											</div>

											<?php if (Sentry::user()->hasAccess('form.delete')): ?>
												<div class="btn-group">
													<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-small btn-danger tooltip-top field-action icn16" title="<?php echo ucfirst(lang('action.delete')).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
												</div>
											<?php endif;?>
										</div>
									</td>
									<td class="span1 reorder"></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php else: ?>
						<p class="alert"><?php echo lang('error.notFound', lang('fields')).' '.ucfirst(langConcat('for this section'));?></p>
					<?php endif;?>
				</fieldset>
			<?php endforeach;?>
		<?php else: ?>
			<p class="alert"><?php echo lang('error.notFound', lang('fields')).' '.ucfirst(langConcat('for this tab'));?></p>
		<?php endif;?>
		</div>
	<?php endforeach;?>
	</div>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<?php foreach ($sections as $s): ?>
			<fieldset>
				<legend><?php echo $s->name;?><?php if ($s->status === Status::INACTIVE){ echo ' <small>'.ucfirst(lang('inactive')).'</small>';}?></legend>

				<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
					<table width="100%" class="table-striped sort-field">
						<tbody class="sort-body">
						<?php foreach ($fields[$s->id] as $f): ?>
							<tr id="field_<?php echo $f->id;?>">
								<td class="span9 control-group">
									<label class="control-label">
										<?php echo $f->label;?>
										<?php if ($f->status === Status::INACTIVE): ?>
											<span class="muted">(<?php echo ucfirst(lang('inactive'));?>)</span>
										<?php endif;?>
									</label>
									<div class="controls">
										<?php if ($f->type == 'text'): ?>
											<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
										<?php elseif ($f->type == 'textarea'): ?>
											<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
										<?php elseif ($f->type == 'select'): ?>
											<?php echo Form::select($f->html_name, $f->value, $f->getValues(), array('class' => $f->html_class, 'id' => $f->html_id));?>
										<?php endif;?>
									</div>
								</td>
								<td class="span2">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(lang('action.edit')).' '.$f->label;?>"><div class="icn icn-50" data-icon="p"></div></a>
										</div>

										<?php if (Sentry::user()->hasAccess('form.delete')): ?>
											<div class="btn-group">
												<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-mini btn-danger tooltip-top field-action" title="<?php echo ucfirst(lang('action.delete')).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
											</div>
										<?php endif;?>
									</div>
								</td>
								<td class="span1 reorder"></td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<p class="alert"><?php echo lang('error.notFound', lang('fields')).' '.ucfirst(langConcat('for this section'));?></p>
				<?php endif;?>
			</fieldset>
		<?php endforeach;?>
	<?php else: ?>
		<?php if ($fields !== false): ?>
			<table width="100%" class="table-striped sort-field">
				<tbody class="sort-body">
				<?php foreach ($fields as $f): ?>
					<tr id="field_<?php echo $f->id;?>">
						<td class="span9 control-group">
							<label class="control-label">
								<?php echo $f->label;?>
								<?php if ($f->status === Status::INACTIVE): ?>
									<span class="muted">(<?php echo ucfirst(lang('inactive'));?>)</span>
								<?php endif;?>
							</label>
							<div class="controls">
								<?php if ($f->type == 'text'): ?>
									<?php echo Form::input(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value));?>
								<?php elseif ($f->type == 'textarea'): ?>
									<?php echo Form::textarea(array('name' => $f->html_name, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $f->value, 'rows' => $f->html_rows));?>
								<?php elseif ($f->type == 'select'): ?>
									<?php echo Form::select($f->html_name, $f->value, $f->getValues(), array('class' => $f->html_class, 'id' => $f->html_id));?>
								<?php endif;?>
							</div>
						</td>
						<td class="span2">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key.'/'.$f->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(lang('action.edit')).' '.$f->label;?>"><div class="icn icn-50" data-icon="p"></div></a>
								</div>

								<?php if (Sentry::user()->hasAccess('form.delete')): ?>
									<div class="btn-group">
										<a href="<?php echo Uri::create('admin/form/fields/'.$f->form_key);?>" class="btn btn-mini btn-danger tooltip-top field-action" title="<?php echo ucfirst(lang('action.delete')).' '.$f->label;?>" data-action="delete" data-id="<?php echo $f->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
									</div>
								<?php endif;?>
							</div>
						</td>
						<td class="span1 reorder"></td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="alert"><?php echo lang('error.notFound', langConcat('form fields'));?></p>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>