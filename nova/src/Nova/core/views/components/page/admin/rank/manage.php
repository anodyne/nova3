<div class="btn-toolbar">
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/index');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(langConcat('ranks index'));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/manage/0');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.create', lang('rank')));?>"><div class="icn icn-75" data-icon="+"></div></a>
	</div>

	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/info');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank info')));?>"><div class="icn icn-75" data-icon="i"></div></a>
		<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank groups')));?>"><div class="icn icn-75" data-icon=","></div></a>
	</div>

	<div class="btn-group pull-right">
		<form method="post">
			<?php echo Form::hidden('action', 'changeSet');?>
			<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
			
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend input-append">
						<span class="add-on font-small"><?php echo ucwords(langConcat('action.change rank set'));?></span><?php echo Form::select('changeSet', $default, $sets);?><button type="submit" class="btn icn16"><div class="icn icn-50" data-icon=">"></div></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if (count($groups) > 0): ?>
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
		<?php foreach ($groups as $g): ?>
			<li><a href="#group<?php echo $g->id;?>" data-toggle="tab"><?php echo $g->name;?></a></li>
		<?php endforeach;?>
		</ul>

		<div class="tab-content">
		<?php foreach ($groups as $g): ?>
			<div id="group<?php echo $g->id;?>" class="tab-pane">
				<?php if (count($g->ranks) > 0): ?>
					<table class="table table-striped">
						<tbody>
						<?php foreach ($g->ranks as $r): ?>
							<tr>
								<td class="span3"><?php echo $r->info->name;?></td>
								<td class="span3"><?php echo Location::rank($r->base, $r->pip, $default);?></td>
								<td class="span4"></td>
								<td class="span2">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="<?php echo Uri::create('admin/rank/manage/'.$r->id);?>" class="btn btn-mini tooltip-top" title="<?php echo ucfirst(lang('action.edit'));?>"><div class="icn icn-50" data-icon="p"></div></a>
										</div>

										<?php if (Sentry::user()->hasAccess('rank.delete')): ?>
											<div class="btn-group">
												<a href="#" class="btn btn-danger btn-mini tooltip-top rank-action" title="<?php echo ucfirst(lang('action.delete'));?>" data-action="delete" data-id="<?php echo $r->id;?>"><div class="icn icn-50" data-icon="x"></div></a>
											</div>
										<?php endif;?>
									</div>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<p class="alert"><?php echo lang('error.notFound', lang('ranks'));?></p>
				<?php endif;?>
			</div>
		<?php endforeach;?>
		</div>
	</div>
<?php else: ?>
	<p class="alert"><?php echo lang('error.notFound', langConcat('rank groups'));?></p>
<?php endif;?>