<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/application/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('short.backToIndex');?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo ucfirst(lang('short.show', lang('in_progress')));?>" data-status="inprogress"><div class="icn icn-75" data-icon="'"></div></a>
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo ucfirst(lang('short.show', lang('approved')));?>" data-status="approved"><div class="icn icn-75" data-icon="4"></div></a>
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo ucfirst(lang('short.show', lang('rejected')));?>" data-status="rejected"><div class="icn icn-75" data-icon="2"></div></a>
	</div>

	<div class="btn-group">
		<a href="#" class="btn icn16 status-toggle tooltip-top" title="<?php echo ucfirst(lang('short.clear', lang('filter')));?>" data-status="all"><div class="icn icn-75" data-icon="x"></div></a>
	</div>
</div>

<?php if ($applications): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($applications as $r): ?>
			<tr class="status-<?php echo $r->status;?>">
				<td>
					<span class="lead"><?php echo $r->character->getName(false);?></span><br>

					<?php if ($r->status == Status::IN_PROGRESS): ?>
						<span class="label label-info"><span class="icn icn-75" data-icon="'"></span></span>
					<?php elseif ($r->status == Status::APPROVED): ?>
						<span class="label label-success"><span class="icn icn-75" data-icon="4"></span></span>
					<?php elseif ($r->status == Status::REJECTED): ?>
						<span class="label label-important"><span class="icn icn-75" data-icon="x"></span></span>
					<?php endif;?>

					<span class="muted"><?php echo $r->position->name;?></span>
				</td>
				<td class="span2">
					<div class="btn-toolbar">
						<div class="btn-group">
							<?php if (count($r->getComments()) > 0): ?>
								<span class="btn btn-sm btn-noclick tooltip-top icn16" title="<?php echo ucfirst(lang('comments'));?>"><span class="icn icn-50" data-icon="c"></span> <?php echo count($r->getComments());?></span>
							<?php endif;?>

							<?php if (count($r->getVotes('yes')) > 0): ?>
								<span class="btn btn-sm btn-noclick tooltip-top icn16" title="<?php echo ucfirst(langConcat('yes votes'));?>"><span class="icn icn-50" data-icon="."></span> <?php echo count($r->getVotes('yes'));?></span>
							<?php endif;?>

							<?php if (count($r->getVotes('no')) > 0): ?>
								<span class="btn btn-sm btn-noclick tooltip-top icn16" title="<?php echo ucfirst(langConcat('no votes'));?>"><span class="icn icn-50" data-icon="/"></span> <?php echo count($r->getVotes('no'));?></span>
							<?php endif;?>
						</div>
					</div>
				</td>
				<td class="span2">
					<div class="btn-toolbar pull-right">
						<?php if ($r->status == Status::REJECTED): ?>
							<div class="btn-group">
								<?php if (Model_Ban::getItems($r->user->email)): ?>
									<a href="#" class="btn btn-sm btn-danger tooltip-top unban-user icn16" title="<?php echo ucfirst(lang('short.remove', langConcat('user ban')));?>" data-user="<?php echo $r->user->id;?>"><div class="icn icn-50" data-icon="2"></div></a>
								<?php else:?>
									<a href="#" class="btn btn-sm btn-danger tooltip-top ban-user icn16" title="<?php echo ucfirst(langConcat('action.ban user'));?>" data-user="<?php echo $r->user->id;?>"><div class="icn icn-50" data-icon="2"></div></a>
								<?php endif;?>
							</div>
						<?php endif;?>

						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>" class="btn btn-sm icn16"><div class="icn icn-50" data-icon=">"></div></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	{{ partial('common/alert', ['content' => lang('error.notFound', lang('applications'))]) }}
<?php endif;?>