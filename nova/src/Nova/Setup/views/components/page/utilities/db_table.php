<p class="alert alert-danger hide">Table creation failed</p>

<p class="alert alert-success hide">Table created</p>

<div class="controls">
	<label class="control-label">Table Name</label>
	<?php echo Form::input('table_name');?>
	<span class="loading-table hide"><?php echo Html::img($images['loading']['src'], $images['loading']['attr']);?></span>
</div>

<p class="help-block">Do not put the database prefix (<em><?php echo DB::table_prefix();?></em>), it will be added for you.</p>