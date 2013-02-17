<div class="btn-toolbar">
	<?php if (Sentry::user()->hasAccess('role.create')): ?>
		<div class="btn-group">
			<a href="<?php echo Uri::create('admin/role/index/0');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.add', langConcat('access role')));?>"><div class="icn icn-75" data-icon="+"></div></a>
		</div>
	<?php endif;?>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/role/tasks');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.manage', langConcat('access tasks')));?>"><div class="icn icn-75" data-icon=","></div></a>
	</div>
</div>

<?php if (count($roles) > 0): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($roles as $r): ?>
			<tr>
				<td>
					<span class="lead"><?php echo $r->name;?></span><br>
					<span class="muted"><?php echo Markdown::parse($r->desc);?></span>
				</td>
				<td class="span3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-small tooltip-top role-action icn16" title="<?php echo ucfirst(lang('short.view', langConcat('users with this role')));?>" data-action="view" data-id="<?php echo $r->id;?>"><div class="icn icn-50" data-icon="s"></div></a>
							<a href="<?php echo Uri::create('admin/role/edit/'.$r->id);?>" class="btn btn-small tooltip-top icn16" title="<?php echo ucfirst(lang('short.edit', lang('role')));?>"><div class="icn icn-50" data-icon="p"></div></a>

							<?php if (Sentry::user()->hasAccess('role.create')): ?>
								<a href="#" class="btn btn-small tooltip-top role-action icn16" title="<?php echo ucfirst(lang('short.duplicate', lang('role')));?>" data-action="duplicate" data-id="<?php echo $r->id;?>"><div class="icn icn-50" data-icon="_"></div></a>
							<?php endif;?>
						</div>

						<?php if (Sentry::user()->hasAccess('role.delete')): ?>
							<div class="btn-group">
								<a href="#" class="btn btn-small btn-danger tooltip-top role-action icn16" title="<?php echo ucfirst(lang('short.delete', lang('role')));?>" data-action="delete" data-id="<?php echo $r->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
							</div>
						<?php endif;?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p class="alert"><?php echo lang('error.notFound', langConcat('access roles'));?></p>
<?php endif;?>