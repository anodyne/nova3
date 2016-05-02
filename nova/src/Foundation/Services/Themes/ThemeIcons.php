<?php namespace Nova\Foundation\Services\Themes;

interface ThemeIcons {

	public function getIcon(string $icon);
	public function getIconMap(): array;
	public function renderIcon(string $icon);

}
