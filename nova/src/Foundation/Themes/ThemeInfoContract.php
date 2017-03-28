<?php namespace Nova\Foundation\Themes;

interface ThemeInfoContract
{
	public function getPreviewImage(array $attributes = []);
	public function getThemePath(): string;
	public function initialize();
}
