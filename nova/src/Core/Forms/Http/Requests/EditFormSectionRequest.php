<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditFormSectionRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'			=> 'required',
			'status'		=> 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name for the section",
			'status.required' => "Please set the status of the section",
		];
	}
}
