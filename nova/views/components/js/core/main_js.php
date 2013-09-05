<?php include_once NOVAPATH.'views/components/js/core/core_js.php';?>

<!--<link rel="stylesheet" href="<?php echo SRCURL;?>/assets/css/bootstrap-editable.css">

<script src="<?php echo SRCURL;?>/assets/js/bootstrap-editable.min.js"></script>-->
<script>
	
	$(document).ready(function()
	{
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