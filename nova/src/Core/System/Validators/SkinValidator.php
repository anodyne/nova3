<?php namespace Nova\Core\Validators\Catalog;

use BaseValidator;

class SkinValidator extends BaseValidator {

	public static $rules = [
		'name'		=> 'required',
		'location'	=> 'required',
		'nav'		=> 'required|in:dropdown,classic',
		'status'	=> 'required|numeric',
	];

}