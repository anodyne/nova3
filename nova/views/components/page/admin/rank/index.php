<ul class="thumbnails">
	<li class="span6">
		<div class="thumbnail">
			<div class="caption">
				<a href="<?php echo Uri::create('admin/rank/manage');?>" class="btn icn16 pull-right"><div class="icn icn-50" data-icon=">"></div></a>
				<h4><?php echo ucfirst(lang('ranks'));?></h4>
			</div>
		</div>
	</li>

	<li class="span6">
		<div class="thumbnail">
			<div class="caption">
				<a href="<?php echo Uri::create('admin/rank/info');?>" class="btn icn16 pull-right"><div class="icn icn-50" data-icon=">"></div></a>
				<h4><?php echo ucwords(langConcat('rank info'));?></h4>
			</div>
		</div>
	</li>

	<li class="span6">
		<div class="thumbnail">
			<div class="caption">
				<a href="<?php echo Uri::create('admin/rank/groups');?>" class="btn icn16 pull-right"><div class="icn icn-50" data-icon=">"></div></a>
				<h4><?php echo ucwords(langConcat('rank groups'));?></h4>
			</div>
		</div>
	</li>

	<li class="span6">
		<div class="thumbnail">
			<div class="caption">
				<a href="<?php echo Uri::create('admin/catalog/ranks');?>" class="btn icn16 pull-right"><div class="icn icn-50" data-icon=">"></div></a>
				<h4 class="muted"><?php echo ucwords(langConcat('rank catalog'));?></h4>
			</div>
		</div>
	</li>
</ul>