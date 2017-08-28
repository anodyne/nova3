<?php namespace Nova\Foundation\Data;

use Nova\Foundation\ActionQueue;

trait QueuesAction
{
	public function queue($component, $action)
	{
		if (auth()->user()->cannot("{$resource}.queue")) {
			return false;
		}

		return creator(ActionQueue::class)->with([
			'user_id' => auth()->id(),
			'resource' => $resource,
			'resource_id' => null,
			'action' => "",
			'payload' => json_encode($this->data),
		])->create();
	}
}
