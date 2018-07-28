<?php

namespace Nova\Foundation\Http\Responses;

use Nova\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;
use Nova\Foundation\Events\NovaResponseEvent;

abstract class BaseResponsable implements Responsable
{
	protected $data;
	protected $page;
	protected $theme;
	protected $output;

	public function __construct($theme, Page $page)
	{
		$this->page = $page;
		$this->theme = $theme;
	}

	public function getRouteName(Request $request)
	{
		return $request->route()->getName();
	}

	public function prepareData() : array
	{
		return $this->data;
	}

	final public function toResponse($request)
	{
		$this->data = $this->prepareData();

		$this->fireNovaResponseEvent($request);

		if ($request->expectsJson()) {
			return response()->json($this->data, Response::HTTP_OK);
		}

		return response($this->render(), Response::HTTP_OK);
	}

	public function views() : array
	{
		return [];
	}

	public function with(array $data = [])
	{
		$this->data = $data;

		return $this;
	}

	protected function fireNovaResponseEvent(Request $request)
	{
		$result = event(new NovaResponseEvent($this->getRouteName($request), $this->data));

		if ($result) {
			$this->data = $result[0];
		}

		return $this;
	}

	protected function getView($view)
	{
		$views = array_merge([
			'structure' => 'app',
			'layout' => $this->page->layout,
			'template' => $this->page->content_template,
			'page' => null,
			'script' => null,
		], $this->views() ?? []);

		return data_get($views, $view, null);
	}

	protected function render()
	{
		$this
			->buildThemeStructure()
			->buildThemeLayout()
			->buildThemeTemplate()
			->buildPage()
			->buildScripts();

		return $this->output;
	}

	protected function buildThemeStructure()
	{
		$this->output = $this->theme->structure($this->getView('structure'), []);

		return $this;
	}

	protected function buildThemeLayout()
	{
		$this->output = $this->theme->layout($this->getView('layout'), []);

		return $this;
	}

	protected function buildThemeTemplate()
	{
		$this->output = $this->theme->template($this->getView('template'), []);

		return $this;
	}

	protected function buildPage()
	{
		$this->output = $this->theme->page($this->getView('page'), $this->data);

		return $this;
	}

	protected function buildScripts()
	{
		$this->output = $this->theme->scripts((array)$this->getView('script'));

		return $this;
	}

	protected function buildSpriteMap()
	{
		$this->output = $this->theme->spriteMap();

		return $this;
	}
}
