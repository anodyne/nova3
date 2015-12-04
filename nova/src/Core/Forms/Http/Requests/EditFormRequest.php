<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditFormRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name'			=> 'required',
			'key'			=> 'required',
			'orientation'	=> 'required|in:vertical,horizontal',
			'status'		=> 'required',
			'form_viewer'	=> 'required',
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
			'form_viewer.required' => "Please select whether this form can use FormViewer",
		];
	}

}
