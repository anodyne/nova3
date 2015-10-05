<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreatePageRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'type' => 'required|in:basic,advanced',

			'basic.name' => 'required_if:type,basic',
			'basic.key' => 'required_if:type,basic',
			'basic.uri' => 'required_if:type,basic',
			'basic.menu_id' => 'required_if:type,basic',

			'advanced.name' => 'required_if:type,advanced',
			'advanced.key' => 'required_if:type,advanced',
			'advanced.uri' => 'required_if:type,advanced',
			'advanced.verb' => 'required_if:type,advanced',
			'advanced.resource' => 'required_if:type,advanced',
			'advanced.menu_id' => 'required_if:type,advanced',

			'content.title' => 'required',
			'content.header' => 'required_if:type,basic',
			'content.message' => 'required_if:type,basic',
		];
	}

	public function messages()
	{
		return [
			'type.required' => "Please select a page type",

			'basic[name].required_if' => "Please enter a name for the page",
			'basic[key].required_if' => "Please enter a key for the page",
			'basic[uri].required_if' => "Please enter a URI for the page",
			'basic[menu_id].required_if' => "Please select a menu for the page",

			'advanced[name].required_if' => "Please enter a name for the page",
			'advanced[key].required_if' => "Please enter a key for the page",
			'advanced[uri].required_if' => "Please enter a URI for the page",
			'advanced[verb].required_if' => "Please select an HTTP Verb",
			'advanced[resource].required_if' => "Please enter a resource for the page",
			'advanced[menu_id].required_if' => "Please select a menu for the page",

			'content[title].required' => "You must enter a page title",
			'content[header].required_if' => "You must enter a page header for a basic page",
			'content[message].required_if' => "You must enter content for a basic page",
		];
	}

}
