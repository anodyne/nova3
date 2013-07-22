<?php namespace Nova\Core\Models\Events\Catalog;

use SystemEvent;
use BaseEventHandler;

class Rank extends BaseEventHandler {
	
	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('rank_set catalog'), $model->name, lang('action.created'));
	}

	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('rank_set catalog'), $model->name, lang('action.updated'));
	}

	public function deleting($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('rank_set catalog'), $model->name, lang('action.deleted'));
	}

}