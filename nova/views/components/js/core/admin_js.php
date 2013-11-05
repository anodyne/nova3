<?php include_once NOVAPATH.'views/components/js/core/core_js.php';?>

<script src="<?php echo NOVAURL;?>assets/js/jquery.blockUI.min.js"></script>
<script>

	$(document).ready(function()
	{
		$.lazy({
			src: "<?php echo URL::to('nova/assets/js/jquery.Jcrop.min.js');?>",
			name: 'Jcrop',
			cache: true,
			dependencies: {
				css: ["<?php echo URL::to('nova/assets/css/jquery.Jcrop.min.css');?>"]
			}
		});
	});

</script>