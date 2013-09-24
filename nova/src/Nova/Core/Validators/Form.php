<?php namespace Nova\Core\Validators;

use BaseValidator;

class Form extends BaseValidator {

	public static $rules = [
		'key'			=> 'required',
		'name'			=> 'required',
		'orientation'	=> 'required|in:vertical,horizontal',
		'status'		=> 'required|numeric',
	];

}