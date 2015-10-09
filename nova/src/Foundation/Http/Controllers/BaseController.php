<?php namespace Nova\Foundation\Http\Controllers;

use stdClass;
use Illuminate\Routing\Controller,
	Illuminate\Contracts\Foundation\Application,
	Illuminate\Foundation\Bus\DispatchesJobs,
	Illuminate\Foundation\Validation\ValidatesRequests;

abstract class BaseController extends Controller {

	use DispatchesJobs, ValidatesRequests;

	protected $app;
	protected $page;
	protected $theme;
	protected $content;
	protected $settings;
	protected $user = false;

	protected $data;
	protected $jsData;
	protected $styleData;
	protected $view;
	protected $jsView;
	protected $styleView;
	protected $isAjax = false;

	protected $templateData;
	protected $templateView = 'public';
	protected $structureData;
	protected $structureView = 'public';

	public function __construct()
	{
		$this->app				= app();
		$this->data				= new stdClass;
		$this->jsData			= new stdClass;
		$this->styleData		= new stdClass;
		$this->user				= app('nova.user');
		$this->templateData 	= new stdClass;
		$this->structureData	= new stdClass;

		// $this can't be used in closures, so we need another variable
		$me = $this;

		// Check if Nova is installed
		$this->beforeFilter(function()
		{
			if ( ! app('nova.setup')->isInstalled())
			{
				return redirect()->route('setup.env');
			}
		});

		// Bind some data to all views
		$this->beforeFilter(function($route, $request) use (&$me)
		{
			if (app('nova.setup')->isInstalled())
			{
				$me->page = app('PageRepository')->getByRouteKey($request->route());
				$me->content = app('nova.pageContent');
				$me->settings = app('nova.settings');

				view()->share('_page', $me->page);
				view()->share('_user', $me->user);
				view()->share('_icons', app('nova.theme')->getIconMap());
				view()->share('_settings', $me->settings);
				view()->share('_content', $me->content);
			}
		});

		// Render the template after everything is done
		$this->afterFilter('@processController');
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
			? "{$this->user->name} attempted to access ".app('request')->fullUrl()
			: "An unauthenticated user attempted to access ".app('request')->fullUrl();

		app('log')->warning($logMessage);

		abort(404, $message);
	}

	public function errorUnauthorized($message = null)
	{
		$logMessage = ($this->user)
			? "{$this->user->name} attempted to access ".app('request')->fullUrl()
			: "An unauthenticated user attempted to access ".app('request')->fullUrl();
		
		app('log')->warning($logMessage);

		nova_event();

		dd(app('request')->ajax());

		if (app('request')->ajax())
		{
			return response()->json([
				'status'	=> 403,
				'message'	=> $message,
			]);
		}

		abort(403, $message, ['foo' => $message]);
	}

	public function processController($route, $request, $response)
	{
		if (app('nova.setup')->isInstalled())
		{
			if ( ! $this->isAjax)
			{
				$this->buildThemeStructure();

				$this->buildThemeTemplate();

				$this->buildThemeMenu();

				$this->buildThemePage();

				$this->buildThemeJavascript();

				$this->buildThemeStyles();

				$this->buildThemeFooter();

				$response->setContent($this->theme->render());
			}
		}
	}

	protected function buildThemeStructure()
	{
		$this->theme = app('nova.theme')->structure($this->structureView, (array) $this->structureData);
	}

	protected function buildThemeTemplate()
	{
		$this->theme = $this->theme->template($this->templateView, (array) $this->templateData);
	}

	protected function buildThemeMenu()
	{
		$this->theme = $this->theme->menu($this->page);
	}

	protected function buildThemePage()
	{
		if ($this->view)
		{
			$this->theme = $this->theme->page($this->view, (array) $this->data);
		}
	}

	protected function buildThemeJavascript()
	{
		if ($this->jsView)
		{
			$this->theme = $this->theme->javascript($this->jsView, (array) $this->jsData);
		}
	}

	protected function buildThemeStyles()
	{
		if ($this->styleView)
		{
			$this->theme = $this->theme->styles($this->styleView, (array) $this->styleData);
		}
	}

	protected function buildThemeFooter()
	{
		$data = [];

		$this->theme = $this->theme->footer($data);
	}

	public function renderTemplate($route, $request, $response)
	{
		if (app('nova.setup')->isInstalled())
		{
			$layout = view(locate()->structure($this->structureView));

			if ($this->jsView)
			{
				$layout->javascript = view(locate()->js($this->jsView))->with((array) $this->jsData);
			}

			$layout->template = view(locate()->template($this->templateView));

			if ($this->view)
			{
				$layout->template->content = view(locate()->page($this->view))->with((array) $this->data);
			}

			$response->setContent($layout);
		}
	}

	final public function page(){}

}
