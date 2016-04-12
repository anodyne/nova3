<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreateFormRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
			'key' => 'required',
			'orientation' => 'required|in:vertical,horizontal',
			'status' => 'required',
			'use_form_center' => 'required',
			'allow_multiple_submissions' => 'required',
			'allow_entry_editing' => 'required',
			'allow_entry_removal' => 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'Please enter a form name',
			'key.required' => 'Please enter a form key',
			'orientation.required' => "Please select a form orientation",
			'orientation.in' => "Please select a valid form orientation",
			'status.required' => "Please select a status",
			'use_form_center.required' => "Please select whether this form can use Form Center",
			'allow_multiple_submissions.required' => "Please select whether users can submit this form multiple times",
			'allow_entry_editing.required' => "Please select whether users can edit their submission(s) for this form",
			'allow_entry_removal.required' => "Please select whether users can remove their submission(s) for this form",
		];
	}

}
