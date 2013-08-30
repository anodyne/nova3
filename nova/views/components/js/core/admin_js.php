<?php include_once NOVAPATH.'views/components/js/core/core_js.php';?>

<script type="text/javascript" src="<?php echo NOVAURL;?>assets/js/jquery.blockUI.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		
		$.lazy({
			src: "<?php echo URL::to('nova/assets/js/jquery.quicksearch.js');?>",
			name: 'quicksearch',
			cache: true
		});
	});
</script>