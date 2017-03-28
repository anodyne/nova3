<?php namespace Nova\Core\Users\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreateUserRequest extends Request
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed',
			'role' => 'required',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name",
			'email.required' => "Please enter an email address",
			'email.email' => "Please enter a valid email address",
			'password.required' => "Please enter a password",
			'password.confirmed' => "Passwords do not match",
			'role.required' => "Please select an access role",
		];
	}
}
