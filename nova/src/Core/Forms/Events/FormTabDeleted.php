<?php namespace Nova\Core\Forms\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormTabDeleted extends Event
{
	use SerializesModels;

	public $id;
	public $name;
	public $formKey;
	public $creating = false;
	public $updating = false;
	public $deleting = true;

	public function __construct($id, $name, $formKey)
	{
		$this->id = $id;
		$this->name = $name;
		$this->formKey = $formKey;
	}
}
