<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreateFormFieldRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'type' => 'required|in:text,textarea,select,radio'
		];
	}

	public function messages()
	{
		return [
			'type.required' => "You must choose a field type",
			'type.in' => "You have specified an invalid field type"
		];
	}

}
