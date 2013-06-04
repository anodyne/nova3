<div class="btn-group">
	<?php if (Sentry::user()->hasLevel('character.create', 2)): ?>
		<a href="<?php echo Uri::create('admin/application/rules');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('action.manage rules'));?>"><div class="icn icn-75" data-icon=","></div></a>
	<?php endif;?>
	
	<a href="<?php echo Uri::create('admin/application/history');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('action.view history'));?>"><div class="icn icn-75" data-icon="h"></div></a>
</div>

<?php if ($reviews !== false): ?>
	<table class="table table-striped">
		<tbody>
		<?php foreach ($reviews as $r): ?>
			<tr>
				<td>
					<span class="lead"><?php echo $r->character->getName(false);?></span><br>
					<span class="muted"><?php echo $r->position->name;?></span>
				</td>
				<td class="span3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<?php if (count($r->getComments()) > 0): ?>
								<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small tooltip-top icn16" title="<?php echo ucfirst(lang('comments'));?>"><span class="icn icn-50" data-icon="c"></span> <?php echo count($r->getComments());?></a>
							<?php endif;?>

							<?php if (count($r->getVotes('yes')) > 0): ?>
								<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small btn-success tooltip-top icn16" title="<?php echo ucfirst(langConcat('yes votes'));?>"><span class="icn" data-icon="."></span> <?php echo count($r->getVotes('yes'));?></a>
							<?php endif;?>

							<?php if (count($r->getVotes('no')) > 0): ?>
								<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>"  class="btn btn-small btn-danger tooltip-top icn16" title="<?php echo ucfirst(langConcat('no votes'));?>"><span class="icn" data-icon="/"></span> <?php echo count($r->getVotes('no'));?></a>
							<?php endif;?>
						</div>

						<div class="btn-group">
							<a href="<?php echo Uri::create('admin/application/review/'.$r->id);?>" class="btn btn-small icn16"><span class="icn icn-50" data-icon=">"></span></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('application reviews'))]) }}
<?php endif;?>