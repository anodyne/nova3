<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('ranks index'));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn icn16 tooltip-top rankinfo-action" title="<?php echo ucfirst(lang('short.create', langConcat('rank info')));?>" data-action="create" data-id="0"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank groups')));?>"><div class="icn icn-75" data-icon=","></div></a>
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', lang('ranks')));?>"><div class="icn icn-75" data-icon="^"></div></a>
	</div>
</div>

<?php if (count($info) > 0): ?>
	<?php foreach ($info as $group => $rankinfo): ?>
		<h3><?php echo ucfirst(lang('group')).' '.$group;?></h3>
		<table width="100%" class="table-striped sort-rankinfo">
			<tbody class="sort-body">
			<?php foreach ($rankinfo as $i): ?>
				<tr height="40" id="info_<?php echo $i->id;?>">
					<td>
						<?php if ($i->status === Status::INACTIVE): ?>
							<span class="label label-important"><?php echo ucfirst(lang('off'));?></span>
						<?php endif;?>
						<?php echo $i->name;?>
					</td>
					<td class="span2">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn btn-small tooltip-top rankinfo-action icn16" title="<?php echo ucfirst(lang('action.edit'));?>" data-action="update" data-id="<?php echo $i->id;?>"><div class="icn icn-50" data-icon="p"></div></a>
							</div>

							<?php if (Sentry::user()->hasAccess('rank.delete')): ?>
								<div class="btn-group">
									<a href="#" class="btn btn-danger btn-small tooltip-top rankinfo-action icn16" title="<?php echo ucfirst(lang('action.delete'));?>" data-action="delete" data-id="<?php echo $i->id;?>"><div class="icn icn-50" data-icon="t"></div></a>
								</div>
							<?php endif;?>
						</div>
					</td>
					<td class="span1 reorder"></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php endforeach;?>
<?php else: ?>
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('rank info'))]) }}
<?php endif;?>