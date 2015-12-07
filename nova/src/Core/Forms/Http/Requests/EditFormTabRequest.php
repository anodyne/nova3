<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditFormTabRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'			=> 'required',
			'link_id'		=> 'required',
			'form_id'		=> 'required',
			'status'		=> 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name for the tab",
			'link_id.required' => "Please enter a link ID for the tab",
			'form_id.required' => "Invalid form ID",
			'status.required' => "Please set the status of the tab",
		];
	}

}
