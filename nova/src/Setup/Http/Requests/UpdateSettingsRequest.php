<?php namespace Nova\Setup\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'sim_name'	=> 'required',
			'theme'		=> 'required',
		];
	}

	public function messages()
	{
		return [
			'sim_name.required' => "Please enter a sim name",
			'theme.required' => "Please select a theme",
		];
	}
}
