<ul class="nav nav-list">
<?php foreach ($items as $item): ?>
	<?php if ($item->order == 0 and $item->group != 0): ?>
		<li class="divider"></li>
	<?php endif;?>

	<?php $targetOutput = ($item->url_target == 'offsite') ? ' target="_blank"' : false;?>

	<li><a href="<?php echo Uri::create($item->url);?>"<?php echo $targetOutput;?>><?php echo $item->name;?></a></li>
<?php endforeach;?>
</ul>