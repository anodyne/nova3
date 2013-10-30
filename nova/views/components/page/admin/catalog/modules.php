<?php if (count($pending) > 0): ?>
	<?php foreach ($pending as $dir => $files): ?>
		<?php $location = str_replace(DS, '', $dir);?>
		<?php $has_readme = file_exists(APPPATH.'modules/'.$location.'/readme.md');?>

		<div class="alert">
			<div class="btn-group pull-right">
				<a class="btn btn-mini btn-icon tooltip-top install" title="<?php echo ucfirst(lang('action.install'));?>" href="#" data-location="<?php echo $location;?>"><i class="icon-ok-sign icon-50"></i></a>
				<?php if ($has_readme): ?>
					<a class="btn btn-mini btn-icon show-readme tooltip-top" title="<?php echo ucwords(langConcat('action.view readme'));?>" href="#"><i class="icon-info-sign icon-50"></i></a>
				<?php endif;?>
			</div>

			<h4 class="alert-heading"><?php echo ucwords($location);?></h4>
			<?php if ($has_readme): ?>
				<span class="hidden"><?php echo Markdown::parse(file_get_contents(APPPATH.'modules/'.$location.'/readme.md'));?></span>
			<?php endif;?>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (count($update) > 0): ?>
	<?php foreach ($update as $u): ?>
		<?php $has_readme = file_exists(APPPATH.'modules/'.$u->location.'/readme.md');?>

		<div class="alert alert-info">
			<div class="btn-group pull-right">
				<a class="btn btn-mini btn-icon tooltip-top update" title="<?php echo ucfirst(lang('action.update'));?>" href="#" data-location="<?php echo $u->location;?>"><i class="icon-circle-arrow-up icon-50"></i></a>
				<?php if ($has_readme): ?>
					<a class="btn btn-mini btn-icon show-readme tooltip-top" title="<?php echo ucwords(langConcat('action.view readme'));?>" href="#"><i class="icon-info-sign icon-50"></i></a>
				<?php endif;?>
			</div>

			<h4 class="alert-heading"><?php echo $u->name;?></h4>
			<?php if ($has_readme): ?>
				<span class="hidden"><?php echo Markdown::parse(file_get_contents(APPPATH.'modules/'.$u->location.'/readme.md'));?></span>
			<?php endif;?>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (count($installed) > 0): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th><?php echo ucfirst(lang('module'));?></th>
				<th><?php echo ucfirst(lang('desc'));?></th>
				<th class="span2"><?php echo ucfirst(lang('actions'));?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($installed as $i): ?>
			<tr>
				<td>
					<?php echo $i->name;?><br>
					<span class="muted font-small"><?php echo 'app/modules/'.$i->location;?></span>
				</td>
				<td><?php echo $i->desc;?></td>
				<td>
					<div class="btn-group">
						<a href="#" class="btn btn-mini btn-icon tooltip-top" title="<?php echo ucfirst(lang('action.edit'));?>"><i class="icon-pencil icon-50"></i></a>
						<a href="#" class="btn btn-mini btn-icon tooltip-top" title="<?php echo ucfirst(lang('action.uninstall'));?>"><i class="icon-ban-circle icon-50"></i></a>

						<?php if (array_key_exists($i->id, $update)): ?>
							<a href="#" class="btn btn-mini btn-icon tooltip-top update" title="<?php echo ucfirst(lang('action.update'));?>" data-location="<?php echo $i->location;?>"><i class="icon-circle-arrow-up icon-50"></i></a>
						<?php endif;?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	{{ partial('common/alert', ['content' => lang('error.notFound', lang('modules'))]) }}
<?php endif;?>