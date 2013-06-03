<script type="text/javascript">
	$(document).on('change', '#baseDrop', function(){

		// get the value from the dropdown
		var rank = $('#baseDrop option:selected').text();

		// put the new image in the div
		$('#basePreview').html('').append('<img src="<?php echo Uri::base(false);?>app/assets/common/<?php echo $genre;?>/ranks/<?php echo $rank;?>/base/' + rank +'">');
	});
</script>

<form method="post">
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('name'));?></label>
		<div class="controls">
			<input type="text" name="name" class="span4">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucwords(langConcat('new base image'));?></label>
		<div class="controls">
			<?php echo Form::select('base', 0, $bases, array('class' => 'span4', 'id' => 'baseDrop'));?>
			<div id="basePreview"></div>
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
		<?php echo Form::hidden('id', $id);?>
		<?php echo Form::hidden('action', 'duplicate');?>
		<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	</div>
</form>