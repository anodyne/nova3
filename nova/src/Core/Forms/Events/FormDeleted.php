<?php namespace Nova\Core\Forms\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormDeleted extends Event {

	use SerializesModels;

	protected $name;
	protected $key;

	public function __construct($name, $key)
	{
		$this->name = $name;
		$this->key = $key;
	}

}
