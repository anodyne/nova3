<?php include_once SRCPATH.'core/views/components/js/core/core_js.php';?>

<script type="text/javascript" src="<?php echo SRCURL;?>assets/js/jquery.blockUI.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		
		$.lazy({
			src: "<?php echo URL::to('nova/src/nova/assets/js/jquery.quicksearch.js');?>",
			name: 'quicksearch',
			cache: true
		});
	});
</script>