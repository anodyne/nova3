<?php namespace Nova\Core\Models\Validators;

use BaseValidator;

class SiteContent extends BaseValidator {

	public static $rules = [
		'key'		=> 'required',
		'label'		=> 'required',
		'type'		=> 'required',
		'uri'		=> 'required_if:type,header|required_if:type,title|required_if:type,message',
	];

}