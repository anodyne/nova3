<?php namespace Nova\Core\Forms\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormTabWasDeleted extends Event {

	use SerializesModels;

	protected $id;
	protected $name;
	protected $formKey;

	public function __construct($id, $name, $formKey)
	{
		$this->id = $id;
		$this->name = $name;
		$this->formKey = $formKey;
	}

}
