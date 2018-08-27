<?php

namespace Nova\Themes;

trait RendersTheme
{
	public $structure;

	final public function structure($view, array $data)
	{
		$this->structure = view("components.structures.{$view}", (array) $data);

		return $this;
	}

	public function layout($view, array $data)
	{
		$this->structure->layout = view("components.layouts.{$view}", (array) $data);
	}

	public function template($view, array $data)
	{
		$this->structure->layout->template = view("components.templates.{$view}", (array) $data);

		return $this;
	}

	public function page($view, array $data)
	{
		$this->structure->layout->template->content = view("components.pages.{$view}", (array) $data);

		return $this;
	}

	public function scripts(array $scripts)
	{
		$output = [];

		foreach ($scripts as $script) {
			if (starts_with($script, ['http://', 'https://', '//'])) {
				$path = $script;
			} else {
				$filePath = view()->getFinder()->find("components.scripts.{$script}");

				// Strip out the base path information
				$path = url(str_replace(base_path(), '', $filePath));
			}

			// Finally, add a script tag
			$output[] = app('html')->script($path);
		}

		$this->structure->scripts = implode("\r\n", $output);

		return $this;
	}

	public function spriteMap()
	{
		if ($this->spriteMap) {
			$this->structure->spriteMap = file_get_contents(url($this->spriteMap));
		}

		return $this;
	}

	public function styles(array $styles)
	{
		$output = "";

		foreach ($styles as $style) {
			// Start by figuring out where the right file is
			$filePath = view()->getFinder()->find("components.styles.{$style}");

			// Next, strip out the base path information
			$path = str_replace(base_path(), '', $filePath);

			// Finally, add a style tag
			$output.= app('html')->style(url($path))."\r\n";
		}

		$this->structure->styles = $output;

		return $this;
	}

	public function entryBeforeHead()
	{
		$this->structure->entryBeforeHead = '';
	}

	public function entryAfterHead()
	{
		$this->structure->entryAfterHead = '';
	}

	public function entryBeforeLayout()
	{
		$this->structure->entryBeforeLayout = '';
	}

	public function entryBeforeTemplate()
	{
		$this->structure->layout->entryBeforeTemplate = '';
	}

	public function entryAfterLayout()
	{
		$this->structure->entryAfterLayout = '';
	}

	public function entryAfterTemplate()
	{
		$this->structure->layout->entryAfterTemplate = '';
	}

	public function __toString()
	{
		try {
			return $this->structure->render();
		} catch (\Exception $ex) {
			dd($ex);
		}
	}
}
