<?php namespace Nova\Core\Validators;

use BaseValidator;

class Navigation extends BaseValidator {

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