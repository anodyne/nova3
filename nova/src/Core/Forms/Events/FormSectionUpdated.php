<?php namespace Nova\Core\Forms\Events;

use NovaFormSection;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormSectionUpdated extends Event {

	use SerializesModels;

	protected $resource;

	public function __construct(NovaFormSection $resource)
	{
		$this->resource = $resource;
	}

}
