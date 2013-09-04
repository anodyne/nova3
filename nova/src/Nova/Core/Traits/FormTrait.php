<?php namespace Nova\Core\Traits;

trait FormTrait {

	/**
	 * Scope the query to a specific form key.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The form key
	 * @return	void
	 */
	public function scopeKey($query, $formKey)
	{
		if ($this->table == 'forms')
		{
			$query->where('key', $formKey);
		}
		else
		{
			// Get the form first
			$form = \NovaForm::key($formKey)->first();

			// Query for the right form ID
			$query->where('form_id', $form->id);
		}
	}

}