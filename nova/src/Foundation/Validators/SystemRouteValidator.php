<?php namespace Nova\Core\Validators;

class SystemRouteValidator extends \BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'verb'		=> 'required',
		'uri'		=> 'required',
		'resource'	=> 'required',
	];

}