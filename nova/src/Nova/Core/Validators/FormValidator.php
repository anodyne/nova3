<?php namespace Nova\Core\Validators;

class FormValidator extends \BaseValidator {

	public static $rules = [
		'key'			=> 'required',
		'name'			=> 'required',
		'orientation'	=> 'required|in:vertical,horizontal',
		'status'		=> 'required|numeric',
	];

}