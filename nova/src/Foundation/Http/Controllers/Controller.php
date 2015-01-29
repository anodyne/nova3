<?php namespace Nova\Foundation\Http\Controllers;

use Locate;
use Illuminate\Foundation\Bus\DispatchesCommands,
	Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

abstract class Controller extends IlluminateController {

	use DispatchesCommands, ValidatesRequests;

	protected $section;
	protected $view;
	protected $data;
	protected $jsView;
	protected $jsData;

	public function __construct()
	{
		// Check if Nova is installed
		$this->middleware('nova.installed');

		// Bind the data we need to all views
		$this->middleware('nova.bindViewData');

		// Render the template
		$this->afterFilter('@renderTemplate');
	}

	public function renderTemplate($route, $request, $response)
	{
		/**
		 * Build the structure
		 */
		$layout = view(Locate::structure($this->section));

		if ($this->jsView)
			$layout->javascript = view(Locate::js($this->jsView))->with((array) $this->jsData);

		/**
		 * Build the template
		 */
		$layout->template = view(Locate::template($this->section));
		$layout->template->content = view(Locate::page($this->view))->with((array) $this->data);

		// Set the content of the response to our full layout now
		$response->setContent($layout);
	}

}
