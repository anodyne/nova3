<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// show the first tab
		//$('.nav-tabs a:first').tab('show');

		$('.nav-tabs').each(function(){

			$('a:first', this).tab('show');
		});

		// validate certain fields of the join form
		$('#joinForm').validate({
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
			ignore: '',
			invalidHandler: function(form, validator){
				// get the number of invalid fields
				var errors = validator.numberOfInvalids();

				// if we have errors
				if (errors)
				{
					// loop through the invalid fields and figure out what tab should be shown
					$.each(validator.invalid, function(field, message){

						// find out what the active tab is
						var tab = $('[name="' + field + '"]').closest('.pill-pane').attr('id');

						// switch to the tab
						$('#joinTabs a[href="#' + tab + '"]').tab('show');

						// now stop
						return;
					});
				}

				return false;
			},
			rules: {
				"user[email]": {
					email: true,
					required: function(){
						if ($('[name="user[id]"]').val() == '0')
							return true;
						else
							return false;
					}
				},
				"user[name]": {
					required: function(){
						if ($('[name="user[id]"]').val() == '0')
							return true;
						else
							return false;
					}
				},
				"user[password]": {
					required: function(){
						if ($('[name="user[id]"]').val() == '0')
							return true;
						else
							return false;
					}
				},
				"user[confirm_password]": {
					required: function(){
						if ($('[name="user[id]"]').val() == '0')
							return true;
						else
							return false;
					},
					equalTo: $('[name="user[password]"]')
				},
				"character[first_name]": {
					required: true
				},
				"position": {
					required: true
				},
				"sample_post": {
					required: true
				}
			}
		});
	});

	// check the email address entered to see if it exists
	$('#emailField').on('change', function(){

		$.ajax({
			type: 'POST',
			url: "<?php echo Uri::create('ajax/get/user');?>",
			data: { 'email': $(this).val() },
			dataType: 'json',
			success: function(data){
				
				if ( ! $.isEmptyObject(data))
				{
					// change the user exists field
					$('[name="user[id]"]').val(data.id);

					// hide the user info
					$('#userInfo').hide();

					// hide the user form
					$('#userForm').hide();

					// show the alert block with instructions
					$('#welcomeBack').fadeIn();
				}
				else
				{
					// change the user exists field
					$('[name="user[id]"]').val(0);

					// show the user info
					$('#userInfo').show();

					// show the user form
					$('#userForm').show();

					// hide the alert block with instructions
					$('#welcomeBack').fadeOut();
				}
			}
		});
	});

	// reset the user form
	$('#userFormReset').on('click', function(){

		$.ajax({
			type: 'POST',
			url: "<?php echo Uri::create('ajax/get/user_form');?>",
			data: {
				'user': 0,
				'skin': '<?php echo $skin;?>'
			},
			dataType: 'json',
			success: function(data){

				// reset the user form
				$('#userForm').empty().html(data);
			}
		});

		// clear the email field
		$('[name="user[email]"]').val('');

		// clear the name field
		$('[name="user[name]"]').val('');

		// clear the password field
		$('[name="user[password]"]').val('');

		// clear the confirm password field
		$('[name="user[confirm_password]"]').val('');

		// hide the alert block with instructions
		$('#welcomeBack').hide();

		// show the user info
		$('#userInfo').show();

		// show the user form
		$('#userForm').show();

		return false;
	});
	
	// join navigation
	$('.joinNavButton').on('click', function(){

		// set some variables to use later
		var direction = $(this).data('direction');
		var activePill = {};

		// find out what the active pill is
		$('.pill-content').children().each(function(){

			if ($(this).hasClass('active'))
			{
				activePill = $(this);
				return;
			}
		});

		// find the tabs in the active pill
		var activePillTab = activePill.find('.nav');

		// does the active pill have tabs?
		var activePillHasTabs = Boolean(activePillTab.length);

		// what's the next pill?
		var pillNextStep = (direction == 'next') ? activePill.next() : activePill.prev();

		if (activePillHasTabs)
		{
			// figure out what the active tab is
			var currentTab = $('li.active a', activePillTab).attr('href');

			// figure out what the first tab is
			var firstTab = $('li:first-child a', activePillTab).attr('href');

			// figure out what the last tab is
			var lastTab = $('li:last-child a', activePillTab).attr('href');

			// what's the next tab?
			var tabNextStep = (direction == 'next') 
				? activePillTab.children('.active').next().children() 
				: activePillTab.children('.active').prev().children();

			if (direction == 'next' && lastTab == currentTab)
			{
				$('#joinTabs a[href="#' + pillNextStep.attr('id') + '"]').tab('show');
			}
			else if (direction == 'prev' && firstTab == currentTab)
			{
				$('#joinTabs a[href="#' + pillNextStep.attr('id') + '"]').tab('show');
			}
			else
			{
				$('a[href="' + tabNextStep.attr('href') + '"]', activePillTab).tab('show');
			}
		}
		else
		{
			$('#joinTabs a[href="#' + pillNextStep.attr('id') + '"]').tab('show');
		}

		return false;
	});
</script>