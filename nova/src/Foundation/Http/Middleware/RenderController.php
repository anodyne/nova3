<?php

namespace Nova\Foundation\Http\Middleware;

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
				// If there is a hook registered for this route, run it
				app('nova.hooks')->run($request->route()->getName());

				$this->buildThemeStructure();
				$this->buildThemeLayout();
				$this->buildThemeTemplate();
				$this->buildPage();
				$this->buildScripts();
				$this->buildSpriteMap();
				// $this->buildStyles();

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

	protected function buildThemeLayout()
	{
		$this->output = app('nova.theme')->layout(
			$this->controller->views->get('layout'),
			(array)$this->controller->layoutData
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

	protected function buildStyles()
	{
		$this->output = app('nova.theme')->styles(
			(array) $this->controller->views->get('style')
		);
	}

	protected function buildSpriteMap()
	{
		$this->output = app('nova.theme')->spriteMap();
	}
}
