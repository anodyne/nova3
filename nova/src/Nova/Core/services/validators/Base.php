<?php namespace Nova\Core\Services\Validators;

use Input;
use Validator;

abstract class Base {

	/**
	 * Attributes to validate.
	 */
	protected $attributes;

	/**
	 * Any errors thrown during validation.
	 */
	protected $errors;

	/**
	 * Gather the attributes to use.
	 *
	 * @param	array	An array of attributes to validate.
	 * @return	void
	 */
	public function __construct($attributes = null)
	{
		$this->attributes = $attributes ?: Input::all();
	}

	/**
	 * Run the validation.
	 *
	 * @return	bool
	 */
	public function passes()
	{
		$validator = Validator::make($this->attributes, static::$rules, static::$messages);

		if ($validator->passes()) return true;

		$this->errors = $validator->messages();

		return false;
	}

}