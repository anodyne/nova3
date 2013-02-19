<p><?php echo $message;?></p>

<?php if (isset($changes) and count($changes) > 0): ?>
	<p><?php echo $check->notes;?></p>

	<hr>
	
	<p>The following changes have been made to Nova since you last updated:</p>
	
	<?php foreach ($changes as $key => $c): ?>
		<?php echo $c;?>
	<?php endforeach;?>
<?php endif;?>