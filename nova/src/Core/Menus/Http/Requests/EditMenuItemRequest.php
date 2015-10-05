<?php namespace Nova\Core\Menus\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class EditMenuItemRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title'				=> 'required_if:type,internal,external,route',
			'authentication'	=> 'required',
			'menu_id'			=> 'required|integer',
			'link'				=> 'required_if:type,external',
			'page_id'			=> 'required_if:type,page',
			'type'				=> 'required|in:page,external,internal,route',
		];
	}

	public function messages()
	{
		return [
			'title.required_if'			=> "Please enter a title for the menu item",
			'authentication.required'	=> "Does this menu require the user to be logged in?",
			'menu_id.required'			=> "Please enter a menu this items should be part of",
			'menu_id.integer'			=> "Please enter a valid menu",
			'link.required_if'			=> "Please provide a link for the menu item",
			'page_id.required_if'		=> "Please select a page",
			'type:required'				=> "Please specify the type of link",
			'type:in'					=> "Page types can only be 'page' or 'external'",
		];
	}

}
