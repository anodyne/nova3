<?php namespace Nova\Core\Pages\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CreatePageRequest extends Request
{
	protected $rules = [
		'type' => 'required|in:basic,advanced',
		'name' => 'required',
		'key' => 'required',
		'uri' => 'required',
		'menu_id' => 'required',
		'verb' => 'required_if:type,advanced',
		'resource' => 'required_if:type,advanced',

		'content.title' => 'required',
		'content.header' => 'required_if:type,basic',
		'content.message' => 'required_if:type,basic',
	];

	protected $messages = [
		'type.required' => "Please select a page type",
		'name.required' => "Please enter a name for the page",
		'key.required' => "Please enter a key for the page",
		'uri.required' => "Please enter a URI for the page",
		'menu_id.required' => "Please select a menu for the page",
		'verb.required_if' => "Please select an HTTP Verb",
		'resource.required_if' => "Please enter a resource for the page",

		'content[title].required' => "You must enter a page title",
		'content[header].required_if' => "You must enter a page header for a basic page",
		'content[message].required_if' => "You must enter content for a basic page",
	];
}
