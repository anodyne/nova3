<?php

return array(
	
	'notFound' => "No :0 found",
	
	'email' => array(
		'couldNotSend' => "The email could not be sent for unknown reasons. Please contact the game master.",
		'validationFailed' => "The email could not be sent because of a validation problem. Please make sure your information is correct and try again.",
	),

	'csrf' => "An invalid security token was detected and the operation was aborted. Please try again.",

	'exception' => array(
		'invalid_image' => "Invalid image type provided. Available options are asset, image, and rank.",
		'model' => array(
			'create' => "The record could not be created. You may find more information in your error logs.",
			'delete' => "No record(s) found to delete. Verify the criteria of your query.",
			'update' => array(
				'notFound' => "No record(s) found to update. Verify the criteria of your query.",
				'notSaved' => "The record could not be updated. You may find more information in your error logs.",
			),
			'get' => array(
				'notFound' => "No record(s) found. Verify the criteria of your query.",
			),
		),
	),

);
