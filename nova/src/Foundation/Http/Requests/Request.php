<?php namespace Nova\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
	protected $rules = [];
	protected $messages = [];
	
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return $this->rules;
	}

	public function messages()
	{
		return $this->messages;
	}
}
