<?php namespace Nova\Core\Forms\Events;

use NovaForm;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormUpdated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(NovaForm $resource)
	{
		$this->resource = $resource;
	}
}
