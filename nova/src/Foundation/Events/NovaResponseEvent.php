<?php

namespace Nova\Foundation\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NovaResponseEvent
{
	use Dispatchable, SerializesModels;

	public $data = [];
	public $route;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($route, array $data)
    {
        $this->route = $route;
        $this->data = $data;
    }
}
