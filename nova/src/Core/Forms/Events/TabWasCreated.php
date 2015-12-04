<?php namespace Nova\Core\Forms\Events;

use NovaFormTab;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class TabWasCreated extends Event {

	use SerializesModels;

	protected $resource;

	public function __construct(NovaFormTab $resource)
	{
		$this->resource = $resource;
	}

}
