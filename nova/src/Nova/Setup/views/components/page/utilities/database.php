<?php if (isset($sub)): ?>
	<h2><?php echo $sub;?></h2>
<?php endif;?>

<p><?php echo $message;?></p>

<?php if (Uri::segment(4) != ''): ?>
	<p><a href="<?php echo Uri::create('setup/utility/database');?>" class="btn-alt">&laquo; Back to Change Database Panel</a></p>
<?php endif;?>

<hr>

<div class="database-content">
	<?php if (Uri::segment(4) == 'table'): ?>
		<?php $data_array = array('images' => $images);?>
		<?php echo View::forge('setup::components/page/utility/db_table', $data_array)->render();?>
	<?php elseif (Uri::segment(4) == 'field'): ?>
		<?php $data_array = array('images' => $images, 'options' => $options, 'fieldtypes' => $fieldtypes);?>
		<?php echo View::forge('setup::components/page/utility/db_field', $data_array)->render();?>
	<?php elseif (Uri::segment(4) == 'query'): ?>
		<?php $data_array = array('images' => $images);?>
		<?php echo View::forge('setup::components/page/utility/db_query', $data_array)->render();?>
	<?php else: ?>
		<a href="<?php echo Uri::create('setup/utility/database/table');?>" class="btn-alt">
			<span class="secoptions-dbtable">Create a new database table</span>
		</a>

		<a href="<?php echo Uri::create('setup/utility/database/field');?>" class="btn-alt">
			<span class="secoptions-dbfield">Create a new database table field</span>
		</a>

		<a href="<?php echo Uri::create('setup/utility/database/query');?>" class="btn-alt">
			<span class="secoptions-dbquery">Run a MySQL query</span>
		</a>
	<?php endif;?>
</div>