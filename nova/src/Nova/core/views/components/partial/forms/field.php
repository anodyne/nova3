<?php $d = data($data, $f->id);?>

<?php if ($editable): ?>
	<div class="control-group">
		<label class="control-label"><?php echo $f->label;?></label>
		<div class="controls">
			<?php if (empty($f->restriction) or (Sentry::check() and Sentry::user()->hasRole($f->restriction))): ?>
				<?php if ($f->type == 'text'): ?>
					<?php echo Form::input(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $d));?>
				<?php elseif ($f->type == 'textarea'): ?>
					<?php echo Form::textarea(array('name' => $f->id, 'class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'value' => $d, 'rows' => $f->html_rows));?>
				<?php elseif ($f->type == 'select'): ?>
					<?php echo Form::select($f->id, $d, $f->getValues(), array('class' => $f->html_class, 'id' => $f->html_id));?>
				<?php endif;?>
			<?php else: ?>
				<?php echo $d;?>
			<?php endif;?>

			<?php if ( ! empty($f->help)): ?>
				<p class="help-block"><?php echo $f->help;?></p>
			<?php endif;?>
		</div>
	</div>
<?php else: ?>
	<?php if ( ! empty($d)): ?>
		<div class="control-group">
			<label class="control-label"><?php echo $f->label;?></label>
			<div class="controls"><?php echo $d;?></div>
		</div>
	<?php endif;?>
<?php endif;?>