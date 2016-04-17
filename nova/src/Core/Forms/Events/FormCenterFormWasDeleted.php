<?php namespace Nova\Core\Forms\Events;

use Nova\Foundation\Events\Event;

class FormCenterFormWasDeleted extends Event {

	protected $id;
	protected $identifier;
	protected $formKey;

	public function __construct($id, $identifier, $formKey)
	{
		$this->id = $id;
		$this->identifier = $identifier;
		$this->formKey = $formKey;
	}

}
