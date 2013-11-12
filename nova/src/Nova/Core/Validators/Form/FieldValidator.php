<?php namespace Nova\Core\Validators\Form;

use BaseValidator;

class FieldValidator extends BaseValidator {

	public static $rules = [
		'form_id'		=> 'required|numeric',
		'tab_id'		=> 'numeric',
		'section_id'	=> 'numeric',
		'status'		=> 'required|numeric',
		'order'			=> 'numeric',
		'type'			=> 'required|in:text,textarea,select',
		'label'			=> 'required',
		'html_rows'		=> 'numeric',
	];

}