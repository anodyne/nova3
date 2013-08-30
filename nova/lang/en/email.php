<?php

return array(

	'subject' => array(
		'arc' => array(
			'addReviewer' => "Application Review",
			'reviewStart' => 'New Application Review Started',
			'emailApplicant' => 'Email Regarding Your Application',
			'response' => 'Application Response',
		),

		'formviewer' => "New :0 Submission",

		'user' => array(
			'add' => "User Record Created",
		),
	),

	'content' => array(
		'arc' => array(
			'addReviewer' => "You have been added to an application review. From the Application Review Center you can review the application, comment on it and vote on whether you think it should be approved or rejected.\r\n\r\n<a href='".URL::to('login')."'>Log in</a> to start participating in the review.",
			'reviewStart' => "A new application has been received and is available for review. From the Application Review Center you can review the application, comment on it and vote on whether you think it should be approved or rejected.\r\n\r\n<a href='".URL::to('login')."'>Log in</a> to start participating in the review.",
		),

		'user' => array(
			'add' => "A :0 record has been manually created for you on the :1 RPG (:2). Your :3 details are below:\r\n\r\nName: :4\r\nPassword: :5",
		),
	),

	'error' => array(
		'noToAddress' => "Could not find TO address data.",
		'noSubject' => "Could not find SUBJECT data.",
	),

	'help' => array(
		'notify' => "When a new :0 is created, you will be notified about it through email",
		'notifyPostsAction' => "When a joint :0 you're involved in is :1, you will be notified about it through email",
		'notifyComments' => "When a new :0 is added to a :1, :2, or :3 that you're part of, you will be notified about it through email",
		'notifyMessages' => "When you're sent a new :0, you will be notified about it through email",
	),
	
);