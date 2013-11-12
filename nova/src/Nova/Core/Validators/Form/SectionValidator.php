<?php namespace Nova\Core\Validators\Form;

use BaseValidator;

class SectionValidator extends BaseValidator {

	public static $rules = [
		'form_id'	=> 'required|numeric',
		'tab_id'	=> 'numeric',
		'status'	=> 'required|numeric',
		'order'		=> 'numeric',
	];

}