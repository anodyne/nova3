<?php

/**
 * Site Content - Emails
 */

return [

	[
		'key' => 'accept_message',
		'label' => 'User Acceptance Email',
		'content' => "Define your user acceptance message through the Site Content page.",
		'type' => 'email'
	],
	[
		'key' => 'reject_message',
		'label' => 'User Rejection Message',
		'content' => "Define your user rejection message through the Site Content page.",
		'type' => 'email'
	],
	
	[
		'key' => 'email.content.formviewer_results',
		'label' => 'FormViewer Results Message',
		'content' => "",
		'type' => 'email'
	],
	[
		'key' => 'email.subject.password_reset',
		'label' => 'Password Reset Subject Line',
		'content' => "Confirm Password Reset",
		'type' => 'email'
	],
	[
		'key' => 'email.content.password_reset',
		'label' => 'Password Reset Message',
		'content' => "A password reset has been requested for the account associated with this email address. Since this is a two step process, you must now confirm your reset in order for your password to be changed. If you didn't request this reset, please contact the game master immediately and notify them of the issue. After doing so, log in to the site using your current password to cancel the reset request.",
		'type' => 'email'
	],

];