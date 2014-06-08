<?php namespace Nova\Core\Traits;

use App;

trait FormTrait {

	/**
	 * Scope the query to a specific form key.
	 *
	 * @param	Builder		$query	The query builder
	 * @param	string		$key	The form key
	 * @return	void
	 */
	public function scopeKey($query, $key)
	{
		if ($this->table == 'forms')
		{
			$query->where('key', $key);
		}
		else
		{
			// Get the form first
			$form = App::make('FormRepositoryInterface')->findByKey($key);

			// Query for the right form ID
			$query->where('form_id', $form->id);
		}
	}

}