<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class RenderController {

	protected $theme;
	protected $controller;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Grab the instance of the controller out of the container
		$this->controller = app('nova.controller');

		// Assign the response
		$response = $next($request);

		if (app('nova.setup')->isInstalled() and empty($response->getContent()))
		{
			if ( ! $this->controller->isAjax)
			{
				$this->buildThemeStructure();
				$this->buildThemeTemplate();
				$this->buildThemeMenu();
				$this->buildThemeAdminMenu();
				$this->buildThemePage();
				$this->buildThemeJavascript();
				$this->buildThemeStyles();
				$this->buildThemeFooter();
				//$this->buildThemePanel();

				$output = $this->theme->render();

				$response->setContent($output);
			}
		}
		
		return $response;
	}

	protected function buildThemeStructure()
	{
		$this->theme = app('nova.theme')->structure($this->controller->structureView, (array) $this->controller->structureData);
	}

	protected function buildThemeTemplate()
	{
		$this->theme = $this->theme->template($this->controller->templateView, (array) $this->controller->templateData);
	}

	protected function buildThemeMenu()
	{
		$this->theme = $this->theme->menu($this->controller->page);
	}

	protected function buildThemeAdminMenu()
	{
		$this->theme = $this->theme->adminMenu($this->controller->page);
	}

	protected function buildThemePage()
	{
		if ($this->controller->view)
		{
			$this->theme = $this->theme->page($this->controller->view, (array) $this->controller->data);
		}
	}

	protected function buildThemeJavascript()
	{
		if ($this->controller->jsView)
		{
			$this->theme = $this->theme->javascript($this->controller->jsView, (array) $this->controller->jsData);
		}
	}

	protected function buildThemeStyles()
	{
		if ($this->controller->styleView)
		{
			$this->theme = $this->theme->styles($this->controller->styleView, (array) $this->controller->styleData);
		}
	}

	protected function buildThemeFooter()
	{
		$data = [];

		$this->theme = $this->theme->footer($data);
	}

	protected function buildThemePanel()
	{
		$this->theme = $this->theme->panel();
	}

}
