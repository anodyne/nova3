<?php namespace Nova\Core\Forms\Events;

use NovaFormField;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormFieldUpdated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(NovaFormField $resource)
	{
		$this->resource = $resource;
	}
}
