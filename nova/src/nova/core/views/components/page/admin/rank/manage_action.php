<?php

if ( ! function_exists('rankData'))
{
	function rankData($obj, $property, $default = false)
	{
		if (is_object($obj))
		{
			return $obj->{$property};
		}

		return $default;
	}
}

if (is_numeric(Uri::segment(4))): ?>
	<div class="btn-group">
		<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.back', lang('ranks')));?>"><div class="icn icn-75" data-icon="<"></div></a>
	</div>
<?php endif;?>

<form method="post" action="<?php echo Uri::create('admin/ranks/manage');?>">
	<div class="row">
		<div class="span6">
			<div class="control-group">
				<label class="control-label"><?php echo ucwords(langConcat('rank info'));?></label>
				<div class="controls">
					<div class="input-append">
						<?php echo Form::select('info_id', rankData($rank, 'info_id', 0), $infos, array('class' => 'span4'));?><a href="<?php echo Uri::create('admin/rank/info');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank info')));?>"><div class="icn icn-50" data-icon="p"></div></a>
					</div>
				</div>
			</div>
		</div>

		<div class="span6">
			<div class="control-group">
				<label class="control-label"><?php echo ucwords(langConcat('rank group'));?></label>
				<div class="controls">
					<div class="input-append">
						<?php echo Form::select('group_id', rankData($rank, 'group_id'), $groups, array('class' => 'span4'));?><a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn icn16 tooltip-top" title="<?php echo ucfirst(lang('short.edit', langConcat('rank groups')));?>"><div class="icn icn-50" data-icon="p"></div></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (isset($bases) and isset($pips)): ?>
		<div class="control-group">
			<label class="control-label"><?php echo ucfirst(lang('preview'));?></label>
			<div id="rankPreview">
				<?php if ( ! $rankPreview): ?>
					<?php echo \Location::rank('', '');?>
				<?php else: ?>
					<?php echo $rankPreview;?>
				<?php endif;?>
			</div>
		</div>
	<?php endif;?>

	<?php if (isset($bases) and isset($pips)): ?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#baseImage" data-toggle="tab"><?php echo ucwords(langConcat('base image'));?></a></li>
			<li><a href="#pipImage" data-toggle="tab"><?php echo ucwords(langConcat('pip image'));?></a></li>
		</ul>

		<div class="tab-content">
			<div id="baseImage" class="active tab-pane">
				<ul class="thumbnails">
				<?php foreach($bases as $base => $image): ?>
					<li class="span3">
						<div class="caption"><label class="radio inline"><?php echo Form::radio('base', $base, rankData($rank, 'base')).' '.$image;?></label></div>
					</li>
				<?php endforeach;?>
				</ul>
			</div>

			<div id="pipImage" class="tab-pane">
				<ul class="thumbnails">
				<?php foreach($pips as $pip => $image): ?>
					<li class="span3">
						<div class="caption"><label class="radio inline"><?php echo Form::radio('pip', $pip, rankData($rank, 'pip')).' '.$image;?></label></div>
					</li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php else: ?>
		<fieldset>
			<legend><?php echo ucfirst(lang('images'));?></legend>

			<ul class="thumbnails">
			<?php foreach($imgs as $base => $image): ?>
				<?php $fullImage = rankData($rank, 'base').'-'.rankData($rank, 'pip');?>
				<li class="span3">
					<div class="caption"><label class="radio inline"><?php echo Form::radio('base', $base, $fullImage).' '.$image;?></label></div>
				</li>
			<?php endforeach;?>
			</ul>
	<?php endif;?>

	<div class="controls">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', Uri::segment(4));?>
		<?php echo Form::hidden('action', $action);?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>