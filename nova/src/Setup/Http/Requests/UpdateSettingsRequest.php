<?php namespace Nova\Setup\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class UpdateSettingsRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
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
