<?php namespace Nova\Foundation\Themes;

interface ThemeStructureContract
{
	public function structure($view, array $data);
	public function template($view, array $data);
	public function page($view, array $data);
	public function scripts(array $scripts);
	public function styles(array $styles);
	public function footer(array $data = []);
	public function panel();
	public function render();
}
