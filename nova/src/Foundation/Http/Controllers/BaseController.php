<?php namespace Nova\Foundation\Http\Controllers;

use Request;
use stdClass, Closure;
use Illuminate\Routing\Controller,
	Illuminate\Foundation\Bus\DispatchesJobs,
	Illuminate\Contracts\Foundation\Application,
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
		//$debugbar = app('debugbar');

		//$debugbar->startMeasure('BaseControllerConstructor', 'Time for setting up the base controller');
		$this->app				= app();
		$this->data				= new stdClass;
		$this->jsData			= new stdClass;
		$this->styleData		= new stdClass;
		$this->user				= app('nova.user');
		$this->templateData 	= new stdClass;
		$this->structureData	= new stdClass;

		// Make sure Nova is installed
		$this->middleware('nova.installed');

		// Set up the controller
		$this->setupController();

		$me = $this;

		app()->singleton('nova.controller', function () use (&$me) {
			return $me;
		});

		$this->middleware('nova.render');
		//$debugbar->stopMeasure('BaseControllerConstructor');
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

	final public function page(){}

	protected function renderController()
	{
		logger('renderController start');
		$this->middlewareData = new stdClass;

		// All of these need to be used by reference otherwise they never update
		// from what's set later on in the controller
		$this->middlewareData->isAjax = &$this->isAjax;
		$this->middlewareData->structureView = &$this->structureView;
		$this->middlewareData->structureData = &$this->structureData;
		$this->middlewareData->templateView = &$this->templateView;
		$this->middlewareData->templateData = &$this->templateData;
		$this->middlewareData->page = &$this->page;
		$this->middlewareData->view = &$this->view;
		$this->middlewareData->data = &$this->data;
		$this->middlewareData->jsView = &$this->jsView;
		$this->middlewareData->jsData = &$this->jsData;
		$this->middlewareData->styleView = &$this->styleView;
		$this->middlewareData->styleData = &$this->styleData;

		// Serialize the data since we can't pass a full object
		$middlewareDataStr = serialize($this->middlewareData);

		// Render the template after everything is done
		$this->middleware("nova.render:{$middlewareDataStr}");

		logger('renderController end');
	}

	protected function setupController()
	{
		if (app('nova.setup')->isInstalled())
		{
			$this->page = app('PageRepository')->getByRouteKey(Request::route());
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
