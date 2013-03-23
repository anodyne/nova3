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
		),
	),

	'login' => array(
		'lockedOut' => "You've attempted to log in more times than the system allows.",
		'maintenance' => "Maintenance mode has been activated and you cannot log in. Please try again later. If you continue to get this error, please contact the game master.",

		'error1' => "You are not logged in and must do so to continue.",
		'error2' => "The email address you entered is not in our system. Please try again with a valid email address. If you believe you've received this message in error, please <a href=':0'>contact the game master</a>.",
		'error3' => "You did not enter an email address. Please enter an email address to continue.",
		'error4' => "The password you entered does not match our records. Please try again. If you don't remember your password, you can <a href=':0'>reset it</a>.",
		'error5' => "You did not enter a password. Please enter a password to continue.",
		'error6' => "Your email address and password are empty. Please enter a valid email address and password to continue.",
		'error7' => "Too many log in attempts! Your account has been suspended for :0 minutes. Once the ban has passed, you will be able to log in again.",
		'error8' => "Your account as suspended because of too many log in attempts. You will be able to log in in :0 minutes.",
		'error9' => "An unknown error has occurred. Please try again.",
		'error10' => "Your password was successfully reset.",
		
		'resetFailed' => "The password reset failed. Please try again.",
		'authException' => "An unknown authentication occurred when attempting to reset your password. Please make sure your information is correct and try again.",
		'confirmationFailed' => "Your password reset could not be confirmed. Please make sure you have used the right confirmation link and try again.",
	),
);
