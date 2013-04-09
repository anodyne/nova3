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

	'login' => array(
		'notLoggedIn' => "You must log in to continue.",
		'noEmail' => "You did not enter an email address. Please enter an email address and try again.",
		'noPassword' => "You did not enter a password. Please enter a password to continue.",
		'notFound' => "Your user account could not found. Please try again. If you believe an error has occurred, please contact the game master.",
		'suspended' => "You have been suspended for too many log in attempts. You will be able to attempt to log in again in :time minutes.",
		'banned' => "You have been banned from this game. Please contact the game master if you believe this was done in error.",
		
		'maintenance' => "Maintenance mode has been activated and you cannot log in. Please try again later. If you continue to get this error, please contact the game master.",
		'resetFailed' => "The password reset failed. Please try again.",
		'authException' => "An unknown authentication occurred when attempting to reset your password. Please make sure your information is correct and try again.",
		'confirmationFailed' => "Your password reset could not be confirmed. Please make sure you have used the right confirmation link and try again.",
	),
);
