<?php namespace Nova\Core\Users\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserDeleted extends Event {

	use SerializesModels;

	public $id;
	public $name;
	public $email;

	public function __construct($id, $name, $email)
	{
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
	}

}
