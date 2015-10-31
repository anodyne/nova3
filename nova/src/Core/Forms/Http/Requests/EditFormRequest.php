<?php namespace Nova\Core\Forms\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditFormRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [];
	}

	public function messages()
	{
		return [];
	}

}
