<?php namespace Nova\Core\Forms\Events;

use NovaFormTab;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class FormTabCreated extends Event {

	use SerializesModels;
	
	public $resource;
	public $creating = true;
	public $updating = false;
	public $deleting = false;

	public function __construct(NovaFormTab $resource)
	{
		$this->resource = $resource;
	}

}
