<?php namespace Nova\Foundation\Themes;

interface ThemeControlsContract {

	public function button($text, $icon, array $attributes = []);
	public function linkTo($url, $text, $icon, array $attributes = []);
}
