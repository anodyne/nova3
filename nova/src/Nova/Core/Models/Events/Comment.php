<?php namespace Nova\Core\Models\Events;

use Str;
use BaseEventHandler;

class Comment extends BaseEventHandler {

	/**
	 * Before the model is saved, we need to make sure the
	 * commentable_type doesn't have a namespace so we can avoid
	 * issues with people overriding the models.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function saving($model)
	{
		$model->commentable_type = Str::denamespace($model->commentable_type);
	}

}