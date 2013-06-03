<?php include_once SRCPATH.'Core/views/components/js/core/core_js.php';?>

<!--<link rel="stylesheet" href="<?php echo SRCURL;?>/Assets/css/bootstrap-editable.css">

<script type="text/javascript" src="<?php echo SRCURL;?>/Assets/js/bootstrap-editable.min.js"></script>-->
<script type="text/javascript">
	$(document).ready(function(){
		
		<?php /*if (Sentry::check() and Sentry::getUser()->hasAccess('content.update')): ?>

			$('.editable-single').editable("<?php echo URL::to('ajax/update/content_save');?>", {
				loadurl: "<?php echo URL::to('ajax/get/content_load');?>",
				id: 'key',
				cancel: false,
				submit: '<button class="btn btn-mini" type="submit">Save</button>',
				placeholder: ''
			});

			$('.editable-multi').editable("<?php echo URL::to('ajax/update/content_save');?>", {
				loadurl: "<?php echo URL::to('ajax/get/content_load');?>",
				id: 'key',
				type: 'textarea',
				cancel: false,
				submit: '<button class="btn btn-mini" type="submit">Save</button> <span class="muted">&nbsp;Press ESC to discard</span>',
				rows: 5,
				placeholder: ''
			});

		<?php endif;*/?>
	});
</script>