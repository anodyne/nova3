<?php namespace Nova\Foundation\Theme;

use HTML;

trait RendersTheme
{
	public $structure;

	public function structure($view, array $data)
	{
		$this->structure = view("components.structures.{$view}", (array) $data);

		return $this;
	}

	public function template($view, array $data)
	{
		$this->structure->template = view("components.templates.{$view}", (array) $data);

		return $this;
	}

	public function page($view, array $data)
	{
		$this->structure->template->content = view("components.pages.{$view}", (array) $data);

		return $this;
	}

	public function scripts(array $scripts)
	{
		$output = "";

		foreach ($scripts as $script) {
			// Start by figuring out where the right file is
			$filePath = view()->getFinder()->find("components.js.{$script}");

			// Next, strip out the base path information
			$path = str_replace(base_path(), '', $filePath);

			// Finally, add a script tag
			$output.= HTML::script(url($path))."\r\n";
		}

		$this->structure->scripts = $output;

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
			$output.= HTML::style(url($path))."\r\n";
		}

		$this->structure->styles = $output;

		return $this;
	}

	public function __toString()
	{
		return $this->structure->render();
	}
}
