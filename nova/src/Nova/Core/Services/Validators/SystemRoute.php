<?php namespace Nova\Core\Services\Validators;

use BaseValidator;

class SystemRoute extends BaseValidator {

	public static $rules = array(
		'name'		=> 'required',
		'verb'		=> 'required|in:get,put,post,delete',
		'uri'		=> 'required',
		'resource'	=> 'required',
	);

}