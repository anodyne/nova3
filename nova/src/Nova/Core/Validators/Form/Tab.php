<?php namespace Nova\Core\Validators\Form;

use BaseValidator;

class Tab extends BaseValidator {

	public static $rules = [
		'form_id'		=> 'required|numeric',
		'name'			=> 'required',
		'status'		=> 'required|numeric',
	];

}