<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class ProcessController {

	protected $theme;
	protected $controller;
	protected $debug;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$this->debug = app('debugbar');

		//$this->debug->startMeasure('processController', 'Running the after middleware');
		$this->controller = app('nova.controller');

		$response = $next($request);

		if (app('nova.setup')->isInstalled())
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

				$this->debug->startMeasure('render', 'Render the theme');
				$output = $this->theme->render();
				$this->debug->stopMeasure('render');

				//dd($output->render());

				$this->debug->startMeasure('setResponseContent', 'Set the response content');
				$response->setContent($output);
				//return $output;
				$this->debug->stopMeasure('setResponseContent');
			}
		}

		//$this->debug->stopMeasure('processController');
		
		return $response;
	}

	protected function buildThemeStructure()
	{
		$this->debug->startMeasure('buildThemeStructure', 'Build theme structure');
		$this->theme = app('nova.theme')->structure($this->controller->structureView, (array) $this->controller->structureData);
		$this->debug->stopMeasure('buildThemeStructure');
	}

	protected function buildThemeTemplate()
	{
		$this->debug->startMeasure('buildThemeTemplate', 'Build theme template');
		$this->theme = $this->theme->template($this->controller->templateView, (array) $this->controller->templateData);
		$this->debug->stopMeasure('buildThemeTemplate');
	}

	protected function buildThemeMenu()
	{
		$this->debug->startMeasure('buildThemeMenu', 'Build theme menu');
		$this->theme = $this->theme->menu($this->controller->page);
		$this->debug->stopMeasure('buildThemeMenu');
	}

	protected function buildThemeAdminMenu()
	{
		$this->debug->startMeasure('buildThemeAdminMenu', 'Build theme admin menu');
		$this->theme = $this->theme->adminMenu($this->controller->page);
		$this->debug->stopMeasure('buildThemeAdminMenu');
	}

	protected function buildThemePage()
	{
		$this->debug->startMeasure('buildThemePage', 'Build theme page');
		if ($this->controller->view)
		{
			$this->theme = $this->theme->page($this->controller->view, (array) $this->controller->data);
		}
		$this->debug->stopMeasure('buildThemePage');
	}

	protected function buildThemeJavascript()
	{
		$this->debug->startMeasure('buildThemeJavascript', 'Build theme JS');
		if ($this->controller->jsView)
		{
			$this->theme = $this->theme->javascript($this->controller->jsView, (array) $this->controller->jsData);
		}
		$this->debug->stopMeasure('buildThemeJavascript');
	}

	protected function buildThemeStyles()
	{
		$this->debug->startMeasure('buildThemeStyles', 'Build theme styles');
		if ($this->controller->styleView)
		{
			$this->theme = $this->theme->styles($this->controller->styleView, (array) $this->controller->styleData);
		}
		$this->debug->stopMeasure('buildThemeStyles');
	}

	protected function buildThemeFooter()
	{
		$this->debug->startMeasure('buildThemeFooter', 'Build theme footer');
		$data = [];

		$this->theme = $this->theme->footer($data);
		$this->debug->stopMeasure('buildThemeFooter');
	}

}
