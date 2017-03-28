<?php namespace Nova\Core\Forms\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormFieldDeleted extends Event
{
	use SerializesModels;

	protected $id;
	protected $label;
	protected $formKey;

	public function __construct($id, $label, $formKey)
	{
		$this->id = $id;
		$this->label = $label;
		$this->formKey = $formKey;
	}
}
