<?php if ($users): ?>
	<ul>
	<?php foreach ($users as $u): ?>
		<li><?php echo $u->name;?> (<?php echo $u->character->getName();?>)</li>
	<?php endforeach;?>
	</ul>
<?php else: ?>
	<p class="alert"><?php echo lang('error.notFound', lang('users'));?></p>
<?php endif;?>