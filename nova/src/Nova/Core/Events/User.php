<?php namespace Nova\Core\Events;

use Notify;

class User {

	public function onUserCreated($data)
	{
		// Set the content keys
		$contentKeys = [
			'content' => 'email.content.user_create'
		];

		// Send the notification
		Notify::send('basic', $data, $contentKeys);
	}

}