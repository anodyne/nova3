<?php namespace Nova\Core\Validators;

class NavigationValidator extends \BaseValidator {

	public static $rules = [
		'name'			=> 'required',
		'url'			=> 'required',
		'url_target'	=> 'required',
		'needs_login'	=> 'required',
		'access'		=> 'required',
		'type'			=> 'required',
		'category'		=> 'required',
		'status'		=> 'required|integer',
	];

}