<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreateFormSectionRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'			=> 'required',
			'form_id'		=> 'required',
			'status'		=> 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name for the section",
			'form_id.required' => "Invalid form ID",
			'status.required' => "Please set the status of the section",
		];
	}
}
