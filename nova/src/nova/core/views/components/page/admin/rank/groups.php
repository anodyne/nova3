<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('ranks index'));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/info');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank info')));?>"><div class="icn icn-75" data-icon="i"></div></a>
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('ranks')));?>"><div class="icn icn-75" data-icon="^"></div></a>
	</div>
</div>

<form method="post">
	<?php echo Form::hidden('action', 'create');?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	
	<div class="control-group">
		<label class="control-label"><?php echo ucwords(lang('short.add', langConcat('rank group')));?></label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="name" class="span4"><button class="btn icn16"><div class="icn icn-50" data-icon="+"></div></button>
			</div>
		</div>
	</div>
</form>

<?php if (count($groups) > 0): ?>
	<table width="100%" class="table-striped sort-rankgroups">
		<tbody class="sort-body">
		<?php foreach ($groups as $g): ?>
			<tr height="40" id="group_<?php echo $g->id;?>">
				<td>
					<?php if ($g->status === Status::INACTIVE): ?>
						<span class="label label-important"><?php echo ucfirst(lang('off'));?></span>
					<?php endif;?>
					<?php echo $g->name;?>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/rank/groups/'.$g->id);?>" class="btn btn-sm tooltip-top rankgroup-action icn16" title="<?php echo ucfirst(lang('action.edit'));?>" data-action="update" data-id="<?php echo $g->id;?>"><div class="icn icn-50" data-icon="p"></div></a>
							<a href="<?php echo Uri::create('admin/rank/groups/'.$g->id);?>" class="btn btn-sm tooltip-top rankgroup-action icn16" title="<?php echo ucfirst(lang('action.duplicate'));?>" data-action="duplicate" data-id="<?php echo $g->id;?>"><div class="icn icn-50" data-icon="_"></div></a>
						</div>

						<?php if (Sentry::user()->hasAccess('rank.delete')): ?>
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn btn-danger btn-sm tooltip-top rankgroup-action icn16" title="<?php echo ucfirst(lang('action.delete'));?>" data-action="delete" data-id="<?php echo $g->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
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
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('rank groups'))]) }}
<?php endif;?>