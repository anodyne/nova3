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
				$this->buildPage();
				$this->buildJavascript();
				$this->buildStyles();
				$this->buildFooter();
				//$this->buildPanel();

				if ($this->controller->isAdmin)
				{
					$this->buildAdminMenus();
				}
				else
				{
					$this->buildPublicMenus();
				}

				$output = $this->theme->render();

				$response->setContent($output);
			}
		}
		
		return $response;
	}

	protected function buildThemeStructure()
	{
		$this->theme = theme()->structure($this->controller->structureView, (array) $this->controller->structureData);
	}

	protected function buildThemeTemplate()
	{
		$this->theme = $this->theme->template($this->controller->templateView, (array) $this->controller->templateData);
	}

	protected function buildPublicMenus()
	{
		$this->theme = $this->theme->publicMenu($this->controller->page);
	}

	protected function buildAdminMenus()
	{
		$this->theme = $this->theme->adminMenu($this->controller->page);
	}

	protected function buildPage()
	{
		if ($this->controller->view)
		{
			$this->theme = $this->theme->page($this->controller->view, (array) $this->controller->data);
		}
	}

	protected function buildFooter()
	{
		$data = [];

		$this->theme = $this->theme->footer($data);
	}

	protected function buildPanel()
	{
		$this->theme = $this->theme->panel();
	}

	protected function buildJavascript()
	{
		$this->theme = $this->theme->scripts($this->controller->scripts);
	}

	protected function buildStyles()
	{
		$this->theme = $this->theme->styles($this->controller->styles);
	}

}
