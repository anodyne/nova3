<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// validate certain fields of the join form
		$('#userInfoForm').validate({
			errorElement: 'p',
			errorClass: 'help-block',
			highlight: function(element, errorClass) {
				$(element).closest('.form-group').addClass('error');
			},
			unhighlight: function(element, errorClass) {
				$(element).closest('.form-group').removeClass('error');
			},
			errorPlacement: function(error, element) {
				error.insertAfter(element);
			},
			rules: {
				"basic[confirm_password]": {
					equalTo: $('[name="basic[password]"]')
				}
			}
		});
	});

	$('#rankSet').on('change', function(){

		var set = $('#rankSet option:selected').val();

		$.ajax({
			type: "GET",
			url: "<?php echo Uri::create('ajax/info/rank_preview/');?>" + set,
			success: function(data){
				$('#rankImage').html('');
				$('#rankImage').append(data);
			}
		});
	});

	$('#skinMain').on('change', function(){

		var skin = $('#skinMain option:selected').val();

		$.ajax({
			type: "GET",
			url: "<?php echo Uri::create('ajax/info/skin_preview/main/');?>" + skin,
			success: function(data){
				$('#skinMainImage').html('');
				$('#skinMainImage').append(data);
			}
		});
	});

	$('#skinAdmin').on('change', function(){

		var skin = $('#skinAdmin option:selected').val();

		$.ajax({
			type: "GET",
			url: "<?php echo Uri::create('ajax/info/skin_preview/admin/');?>" + skin,
			success: function(data){
				$('#skinAdminImage').html('');
				$('#skinAdminImage').append(data);
			}
		});
	});
</script>