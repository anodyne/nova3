<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('all forms'));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/sections/'.Uri::segment(4).'/0');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.add', lang('section')));?>"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/form/tabs/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('tabs')));?>"><?php echo $images['tabs'];?></a>
		<a href="<?php echo Uri::create('admin/form/fields/'.Uri::segment(4));?>" class="btn tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('fields')));?>"><?php echo $images['fields'];?></a>
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
			<table width="100%" class="table-striped sort-section">
				<tbody class="sort-body">
				<?php foreach ($sections[$t->id] as $s): ?>
					<tr id="section_<?php echo $s->id;?>">
						<td class="span9">
							<p>
								<strong><?php echo $s->name;?></strong>
								<?php if ($s->status === Status::INACTIVE): ?>
									<span class="muted">(<?php echo ucfirst(lang('inactive'));?>)</span>
								<?php endif;?>
							</p>
						</td>
						<td class="span2">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key.'/'.$s->id);?>" class="btn btn-small tooltip-top icn16" title="<?php echo ucfirst(lang('action.edit')).' '.$s->name;?>"><div class="icn icn-50" data-icon="p"></div></a>
								</div>

								<?php if (Sentry::user()->hasAccess('form.delete')): ?>
									<div class="btn-group">
										<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key);?>" class="btn btn-small btn-danger tooltip-top section-action icn16" title="<?php echo ucfirst(lang('action.delete')).' '.$s->name;?>" data-action="delete" data-id="<?php echo $s->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
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
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('sections for this tab'))]) }}
		<?php endif;?>
		</div>
	<?php endforeach;?>
	</div>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<table width="100%" class="table-striped sort-section">
			<tbody class="sort-body">
			<?php foreach ($sections as $s): ?>
				<tr id="section_<?php echo $s->id;?>">
					<td class="span9">
						<p>
							<strong><?php echo $s->name;?></strong>
							<?php if ($s->status === Status::INACTIVE): ?>
								<span class="muted">(<?php echo ucfirst(lang('inactive'));?>)</span>
							<?php endif;?>
						</p>
					</td>
					<td class="span2">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key.'/'.$s->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(lang('action.edit')).' '.$s->name;?>"><div class="icn icn-50" data-icon="p"></div></a>
							</div>

							<?php if (Sentry::user()->hasAccess('form.delete')): ?>
								<div class="btn-group">
									<a href="<?php echo Uri::create('admin/form/sections/'.$s->form_key);?>" class="btn btn-mini btn-danger tooltip-top section-action" title="<?php echo ucfirst(lang('action.delete')).' '.$s->name;?>" data-action="delete" data-id="<?php echo $s->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
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
		{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form sections'))]) }}
	<?php endif;?>
<?php endif;?>