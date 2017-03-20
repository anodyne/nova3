<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreatePageContentRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'key' => 'required',
		];
	}

	public function messages()
	{
		return [
			'key.required' => "Please enter a key for the page content",
		];
	}
}
