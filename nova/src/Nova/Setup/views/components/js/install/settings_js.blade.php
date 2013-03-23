<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#positionDrop').change(function(){
			
			$.ajax({
				type: "POST",
				url: "<?php echo URL::to('ajax/info/position_desc');?>",
				data: { position: $('#positionDrop option:selected').val() },
				success: function(data){
					$('#positionDesc').html('');
					$('#positionDesc').append(data);
					$('#positionDescPanel').show();
				}
			});
			
			return false;
		});
		
		$('#rankDrop').change(function(){
			
			$.ajax({
				type: "POST",
				url: "<?php echo URL::to('ajax/info/rank_image');?>",
				data: {
					rank: $('#rankDrop option:selected').val(),
					location: 'default'
				},
				success: function(data){
					$('#rankImg').html('');
					$('#rankImg').append(data);
				}
			});
			
			return false;
		});

		var v = $('#step1').validate({
			errorElement: 'p',
			errorClass: 'help-inline',
			highlight: function(element, errorClass) {
				$(element).parent().addClass('error');
			},
			unhighlight: function(element, errorClass) {
				$(element).parent().removeClass('error');
			},
			errorPlacement: function(error, element) {
				error.insertAfter(element);
			},
			rules: {
				sim_name: "required",
				name: "required",
				email: {
					required: true,
					email: true
				},
				password: "required",
				password_confirm: {
					required: true,
					equalTo: "#password"
				},
				first_name: "required",
				position: "required",
				rank: "required"
			},
			messages: {
				sim_name: "Please enter your sim's name",
				name: "Please enter your name",
				email: {
					required: "Please enter your email address",
					email: "Please supply a valid email address"
				},
				password: "Please enter a password",
				password_confirm: {
					required: "Please enter your password again",
					equalTo: "Your passwords do not match, try again"
				},
				first_name: "Please enter your character's first name",
				position: "Please select a position",
				rank: "Please select a rank"
			}
		});

		$('#next').click(function(){
			if ($('#step1').valid())
			{
				$('.lower').slideUp();

				$('#loaded').fadeOut('fast', function(){
					$('#loading').fadeIn();
				});
			}
		});
	});
</script>