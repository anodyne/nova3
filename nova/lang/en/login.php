<?php

return [

	'error' => [

		'notLoggedIn' => "You must log in to continue.",
		'noEmail' => "You did not enter an email address. Please enter an email address and try again.",
		'noPassword' => "You did not enter a password. Please enter a password to continue.",
		'notFound' => "Either your user account could not found or you entered your email and/or password incorrectly. Please try again. If you believe an error has occurred, please contact the game master.",
		'suspended' => "You have been suspended for too many log in attempts. You will be able to attempt to log in again in :0 minutes.",
		'banned' => "You have been banned from this game. Please contact the game master if you believe this was done in error.",
		'notAdmin' => "You are not a system administrator and cannot access that section of the site!",
		
		'maintenance' => "Maintenance mode has been activated and you cannot log in. Please try again later. If you continue to get this error, please contact the game master.",

	],

	'reset' => [
		
		'step1Failure' => "The password reset failed. Please try again.",
		'step1Success' => "An email with a confirmation link has been sent to you. Follow that link to complete your password reset.",

		'step2Failure' => "The password reset failed. Please try again.",
		'step2Success' => "Your password reset has been completed. :0 now",
		
		'confirmationFailed' => "Your password reset code could not be confirmed. Please make sure you used the right confirmation link and try again.",

	],

];