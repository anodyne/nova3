<?php namespace Nova\Foundation\Http\Controllers;

use stdClass;
use Illuminate\Routing\Controller,
	Illuminate\Foundation\Bus\DispatchesJobs,
	Illuminate\Foundation\Validation\ValidatesRequests;

abstract class BaseController extends Controller {

	use DispatchesJobs, ValidatesRequests;

	public $app;
	public $page;
	public $theme;
	public $content;
	public $settings;
	public $user = false;

	public $data;
	public $jsData;
	public $styleData;
	public $view;
	public $jsView;
	public $styleView;
	public $isAjax = false;

	public $templateData;
	public $templateView = 'public';
	public $structureData;
	public $structureView = 'public';

	public function __construct()
	{
		$this->app				= app();
		$this->data				= new stdClass;
		$this->jsData			= new stdClass;
		$this->styleData		= new stdClass;
		$this->user				= app('nova.user');
		$this->templateData 	= new stdClass;
		$this->structureData	= new stdClass;

		// Get a copy of $this so we can use it in the binding closure
		$me = $this;

		// Bind a reference to the current controller so that we can use that
		// data from within the template rendering middleware
		$this->app->bind('nova.controller', function ($app) use ($me) {
			return $me;
		});

		// Set up the controller
		$this->setupController();

		// Make sure Nova is installed
		$this->middleware('nova.installed');

		// Process the controller and render it to the response
		$this->middleware('nova.render');
	}

	/**
	 * We don't use Laravel's AuthorizesRequest trait because we want to do a
	 * few special things to make sure unauthorized requests are logged in a
	 * few different places.
	 */
	protected function authorize($ability, $arguments = [], $message = null)
	{
		if ($this->user->cannot($ability, $arguments))
		{
			$this->errorUnauthorized($message);
		}
	}

	public function errorNotFound($message = null)
	{
		$logMessage = ($this->user)
			? $this->user->name
			: "An unauthenticated user";

		$logMessage.= " attempted to access ".app('request')->fullUrl();

		app('log')->warning($logMessage);

		abort(404, $message);
	}

	public function errorUnauthorized($message = null)
	{
		$logMessage = ($this->user)
			? $this->user->name
			: "An unauthenticated user";

		$logMessage.= " attempted to access ".app('request')->fullUrl();
		
		app('log')->warning($logMessage);

		nova_event();

		if (app('request')->ajax())
		{
			return response()->json([
				'status'	=> 403,
				'message'	=> $message,
			]);
		}

		abort(403, $message, ['foo' => $message]);
	}

	final public function page()
	{
		if ($this->page->access)
		{
			if ($this->user and $this->user->cannot($this->page->access))
			{
				return $this->errorUnauthorized("You do not have permission to view the {$this->page->name} page.");
			}
		}
	}

	protected function setupController()
	{
		if (app('nova.setup')->isInstalled())
		{
			$this->page = app('PageRepository')->getByRouteKey(request()->route());
			$this->content = app('nova.pageContent');
			$this->settings = app('nova.settings');

			view()->share('_page', $this->page);
			view()->share('_user', $this->user);
			view()->share('_icons', app('nova.theme')->getIconMap());
			view()->share('_content', $this->content);
			view()->share('_settings', $this->settings);
		}
	}

}
