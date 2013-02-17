<ul class="nav pull-right">
	<?php if ($loggedIn): ?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php if ($notifyTotal > 0): ?><span class="label<?php echo $notifyClass;?>"><?php echo $notifyTotal;?></span><?php endif;?> <?php echo $name;?> <b class="caret"></b>
			</a>

			<ul class="dropdown-menu">
			<?php foreach ($data as $key => $section): ?>
				<?php if ($key != 0): ?>
					<li class="divider"></li>
				<?php endif;?>
				
				<?php foreach ($section as $item): ?>
					<li><a href="<?php echo $item['url'];?>"<?php echo explode(' ', $item['extra']);?>><?php echo $item['name'].$item['additional'];?></a></li>
				<?php endforeach;?>
			<?php endforeach;?>
			</ul>
		</li>
	<?php else: ?>
		<li><a href="<?php echo URL::to('login/index');?>"><?php echo $loginText;?></a></li>
	<?php endif;?>
</ul>