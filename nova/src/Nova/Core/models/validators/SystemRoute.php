<?php namespace Nova\Core\Models\Validators;

use BaseValidator;

class SystemRoute extends BaseValidator {

	public static $rules = array(
		'name'		=> 'required',
		'verb'		=> 'required',
		'uri'		=> 'required',
		'resource'	=> 'required',
	);

}