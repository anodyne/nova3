<?php

if ( ! function_exists('data'))
{
	function data($obj, $i)
	{
		if (is_array($obj))
		{
			return $obj[$i];
		}

		return false;
	}
}

if ($tabs !== false): ?>
	<ul class="nav nav-tabs hidden-phone">
	<?php foreach ($tabs as $t): ?>
		<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?></a></li>
	<?php endforeach;?>
	</ul>

	<!-- These tabs are specific to mobile devices -->
	<ul class="nav nav-tabs nav-stacked hidden-desktop hidden-tablet">
	<?php foreach ($tabs as $t): ?>
		<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?></a></li>
	<?php endforeach;?>
	</ul>
	
	<div class="tab-content">
	<?php foreach ($tabs as $t): ?>
		<div class="tab-pane" id="<?php echo $t->link_id;?>">
		<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
			<?php foreach ($sections[$t->id] as $s): ?>
				
				<?php echo View::forge(Location::file('forms/section', $skin, 'partial'), array('fields' => $fields, 's' => $s, 'skin' => $skin, 'data' => $data, 'editable' => $editable))->render();?>

			<?php endforeach;?>
		<?php endif;?>
		</div>
	<?php endforeach;?>
	</div>
<?php else: ?>
	<?php if ($sections !== false): ?>
		<?php foreach ($sections as $s): ?>

			<?php echo View::forge(Location::file('forms/section', $skin, 'partial'), array('fields' => $fields, 's' => $s, 'skin' => $skin, 'data' => $data, 'editable' => $editable))->render();?>
			
		<?php endforeach;?>
	<?php else: ?>
		<?php if ($fields !== false): ?>
			<?php foreach ($fields as $f): ?>

				<?php echo View::forge(Location::file('forms/field', $skin, 'partial'), array('f' => $f, 'data' => $data, 'editable' => $editable))->render();?>

			<?php endforeach;?>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>