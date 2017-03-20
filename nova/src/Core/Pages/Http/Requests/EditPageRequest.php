<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditPageRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
			'key' => 'required',
			'uri' => 'required',
			'verb' => 'required',
			'resource' => 'required_if:protected,0',
			'menu_id' => 'required',

			'content.title' => 'required',
			'content.header' => 'required_if:type,basic',
			'content.message' => 'required_if:type,basic',
		];
	}

	public function messages()
	{
		return [
			'name.required' => "Please enter a name for the page",
			'key.required' => "Please enter a key for the page",
			'uri.required' => "Please enter a URI for the page",
			'verb.required' => "Please select an HTTP Verb",
			'resource.required_if' => "Please enter a resource for the page",
			'menu_id.required' => "Please select a menu for the page",

			'content[title].required' => "You must enter a page title",
			'content[header].required_if' => "You must enter a page header for a basic page",
			'content[message].required_if' => "You must enter content for a basic page",
		];
	}
}
