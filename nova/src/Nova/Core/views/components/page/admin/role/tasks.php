<?php if (count($tasks) > 0): ?>
	<div class="controls pull-right">
		<input type="text" id="user-search" class="span4 search-query" placeholder="<?php echo ucfirst(lang('short.search', langConcat('for access tasks')));?>">
	</div>
<?php endif;?>

<div class="btn-toolbar">
	<?php if (Sentry::user()->hasAccess('role.create')): ?>
		<div class="btn-group">
			<a href="<?php echo Uri::create('admin/role/tasks/0');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.add', langConcat('access task')));?>"><div class="icn icn-75" data-icon="+"></div></a>
		</div>
	<?php endif;?>

	<?php if (Sentry::user()->hasAccess('role.update')): ?>
		<div class="btn-group">
			<a href="<?php echo Uri::create('admin/role/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.manage', langConcat('access roles')));?>"><div class="icn icn-75" data-icon="("></div></a>
		</div>
	<?php endif;?>
</div>

<?php if (count($tasks) > 0): ?>
	<?php foreach ($tasks as $component => $task): ?>
		<h3><?php echo ucfirst($component);?></h3>

		<table class="table table-striped">
			<tbody>
			<?php foreach ($task as $t): ?>
				<tr>
					<td>
						<span class="lead"><?php echo $t->name;?></span><br>
						<span class="muted fontSmall"><?php echo $t->desc;?></span>
					</td>
					<td class="span3">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn btn-small tooltip-top task-action icn16" title="<?php echo ucfirst(lang('short.view', langConcat('roles with this task')));?>" data-action="view" data-id="<?php echo $t->id;?>"><div class="icn icn-50" data-icon="s"></div></a>
								
								<?php if (Sentry::user()->hasAccess('role.update')): ?>
									<a href="<?php echo Uri::create('admin/role/tasks/'.$t->id);?>" class="btn btn-small tooltip-top icn16" title="<?php echo ucfirst(lang('short.edit', lang('task')));?>"><div class="icn icn-50" data-icon="p"></div></a>
								<?php endif;?>

								<?php if (Sentry::user()->hasAccess('role.create')): ?>
									<a href="#" class="btn btn-small tooltip-top role-action icn16" title="<?php echo ucfirst(lang('short.duplicate', lang('task')));?>" data-action="duplicate" data-id="<?php echo $t->id;?>"><div class="icn icn-50" data-icon="_"></div></a>
								<?php endif;?>
							</div>

							<?php if (Sentry::user()->hasAccess('role.delete')): ?>
								<div class="btn-group">
									<a href="#" class="btn btn-small btn-danger tooltip-top task-action icn16" title="<?php echo ucfirst(lang('short.delete', lang('task')));?>" data-action="delete" data-id="<?php echo $t->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
								</div>
							<?php endif;?>
						</div>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php endforeach;?>
<?php else: ?>
	<p class="alert"><?php echo lang('error.notFound', langConcat('access tasks'));?></p>
<?php endif;?>