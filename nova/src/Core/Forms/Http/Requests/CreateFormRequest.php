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
			'allow_multiple_submissions' => 'required_if:use_form_center,1',
			'resource_store' => 'required_if:use_form_center,1',
			'resource_update' => 'required_if:use_form_center,1',
			'resource_destroy' => 'required_if:use_form_center,1',
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
			'allow_multiple_submissions.required_if' => "Please select whether users can submit this form multiple times",
			'resource_store.required_if' => "Please select the resource for creating form entries",
			'resource_update.required_if' => "Please select the resource for updating form entries",
			'resource_destroy.required_if' => "Please select the resource for deleting form entries",
		];
	}

}
