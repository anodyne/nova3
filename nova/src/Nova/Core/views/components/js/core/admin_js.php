<?php include_once SRCPATH.'Core/views/components/js/core/core_js.php';?>

<script type="text/javascript" src="<?php echo SRCURL;?>Assets/js/jquery.blockUI.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		
		$.lazy({
			src: "<?php echo URL::to('nova/src/Nova/Assets/js/jquery.dialog2.js');?>",
			name: 'dialog2',
			dependencies: {
				js: [
					"<?php echo URL::to('nova/src/Nova/Assets/js/jquery.form.js');?>",
					"<?php echo URL::to('nova/src/Nova/Assets/js/jquery.controls.js');?>"
				]
			},
			cache: true
		});
	});
</script>