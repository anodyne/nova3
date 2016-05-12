<?php namespace Nova\Foundation\Themes;

interface ThemeIconsContract {

	public function buildIconList();
	public function getIcon(string $icon);
	public function getIconMap(): array;
	public function iconTemplate();
	public function renderIcon(string $icon, $additionalClasses = false);

}
