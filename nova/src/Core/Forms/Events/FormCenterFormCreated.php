<?php namespace Nova\Core\Forms\Events;

use NovaForm;
use NovaFormEntry;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormCenterFormCreated extends Event
{
	use SerializesModels;

	public $form;
	public $entry;

	public function __construct(NovaFormEntry $entry, NovaForm $form)
	{
		$this->form = $form;
		$this->entry = $entry;
	}
}
