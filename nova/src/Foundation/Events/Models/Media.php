<?php namespace Nova\Core\Events\Models;

use Str;
use Config;
use BaseModelEventHandler;

class Media extends BaseModelEventHandler {

	public static $lang = 'media';
	public static $name = 'filename';

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
		// Get the aliases
		$aliases = Config::get('app.aliases');

		// Find the key
		$aliasKey = array_search($model->imageable_type, $aliases);

		if ($aliasKey !== false)
			$model->imageable_type = $aliasKey;
	}

}