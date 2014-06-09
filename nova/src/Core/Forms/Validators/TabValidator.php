<?php namespace Nova\Core\Validators\Form;

use BaseValidator;

class TabValidator extends BaseValidator {

	public static $rules = [
		'form_id'		=> 'required|numeric',
		'name'			=> 'required',
		'status'		=> 'required|numeric',
	];

}