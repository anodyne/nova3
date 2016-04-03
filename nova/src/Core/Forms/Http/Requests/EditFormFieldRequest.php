<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditFormFieldRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'type' => 'required'
		];
	}

	public function messages()
	{
		return [
			'type.required' => "You must choose a field type"
		];
	}

}
