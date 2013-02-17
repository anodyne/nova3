<fieldset>
	<?php if ( ! empty($s->name)): ?>
		<legend><?php echo $s->name;?></legend>
	<?php endif;?>

	<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
		<?php foreach ($fields[$s->id] as $f): ?>
			
			<?php echo View::forge(Location::file('forms/field', $skin, 'partial'), array('f' => $f, 'data' => $data, 'editable' => $editable))->render();?>
			
		<?php endforeach;?>
	<?php endif;?>
</fieldset>