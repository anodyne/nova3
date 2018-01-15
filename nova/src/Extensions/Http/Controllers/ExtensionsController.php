<?php namespace Nova\Extensions\Http\Controllers;

use Controller;
use Nova\Extensions\SystemExtension;

class ExtensionsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'structure|template');
	}

	public function index()
	{
		$extensionClass = new SystemExtension;

		$this->authorize('manage', $extensionClass);

		$this->views('extensions.all-extensions', 'page|script');

		$this->pageTitle = "Extensions";

		$this->data->extensionClass = $extensionClass;
		$this->data->extensions = SystemExtension::get();
	}
}
