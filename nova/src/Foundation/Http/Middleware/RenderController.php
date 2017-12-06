<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class RenderController
{
	protected $theme;
	protected $output;
	protected $controller;

	public function handle($request, Closure $next)
	{
		// Grab the instance of the controller out of the container
		$this->controller = app('nova.controller');

		// Assign the response
		$response = $next($request);

		if (nova()->isInstalled() and empty($response->getContent())) {
			if ($this->controller->renderWithTheme) {
				$this->buildThemeStructure();
				$this->buildThemeTemplate();
				$this->buildPage();
				$this->buildScripts();

				$response->setContent($this->output);
			}
		}

		return $response;
	}

	protected function buildThemeStructure()
	{
		$this->output = app('nova.theme')->structure(
			$this->controller->views->get('structure'),
			(array) $this->controller->structureData
		);
	}

	protected function buildThemeTemplate()
	{
		$this->output = app('nova.theme')->template(
			$this->controller->views->get('template'),
			(array) $this->controller->templateData
		);
	}

	protected function buildPage()
	{
		$this->output = app('nova.theme')->page(
			$this->controller->views->get('page'),
			(array) $this->controller->data
		);
	}

	protected function buildScripts()
	{
		$this->output = app('nova.theme')->scripts(
			(array) $this->controller->views->get('script')
		);
	}
}
