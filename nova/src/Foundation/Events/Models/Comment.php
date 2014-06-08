<?php namespace Nova\Core\Events\Models;

use Str;
use BaseModelEventHandler;

class Comment extends BaseModelEventHandler {

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