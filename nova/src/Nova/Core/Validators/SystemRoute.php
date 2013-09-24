<?php namespace Nova\Core\Validators;

use BaseValidator;

class SystemRoute extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'verb'		=> 'required',
		'uri'		=> 'required',
		'resource'	=> 'required',
	];

}