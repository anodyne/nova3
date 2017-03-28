<?php namespace Nova\Setup\Http\Requests;

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
			'user.name' => 'required',
			'user.email' => 'required|email|unique:users,email',
			'user.password' => 'required',
			'user.confirm_password' => 'required|same:user.password',
			'character.first_name' => 'required',
		];
	}

	public function messages()
	{
		return [
			'user.name.required' => 'Please enter your name',
			'user.email.required' => 'Please enter your email address',
			'user.email.email' => 'Please enter a valid email address',
			'user.email.in' => 'That email address is already in use, please choose another',
			'user.password.required' => 'You must enter a password',
			'user.confirm_password.required' => 'You must enter your password again',
			'user.confirm_password.same' => "Your passwords didn't match",
			'character.first_name.required' => 'Please enter a first name for your character',
		];
	}
}
