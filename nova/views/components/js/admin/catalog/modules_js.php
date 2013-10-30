<script type="text/javascript">
	$(document).on('click', '.show-readme', function(e){

		// prevent the default click behavior
		e.preventDefault();

		// get the readme container
		var container = $(this).parent().next().next();

		// figure out if we should be hiding or showing
		if (container.is(':visible'))
			container.addClass('hidden');
		else
			container.removeClass('hidden');
	});

	$(document).ready(function(){
		
		$(".install").click(function(){
			var location = $(this).data('location');

			$('<div/>').dialog2({
				title: "<?php echo ucwords(langConcat('action.install module'));?>",
				content: "<?php echo Uri::create('ajax/add/module');?>/" + location
			});

			return false;
		});

		$(".update").click(function(){
			var location = $(this).data('location');

			$('<div/>').dialog2({
				title: "<?php echo ucwords(langConcat('action.update module'));?>",
				content: "<?php echo Uri::create('ajax/update/module');?>/" + location
			});

			return false;
		});
	});
</script>