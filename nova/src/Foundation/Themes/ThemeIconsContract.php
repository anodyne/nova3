<?php namespace Nova\Foundation\Themes;

interface ThemeIconsContract {

	public function buildIconList($extraClasses = false): array;
	public function getIcon(string $icon);
	public function getIconMap();
	public function iconMap(): array;
	public function renderIcon(string $icon, $extraClasses = false);
	public function renderFontIcon(string $icon, $extraClasses = false);
	public function renderImageIcon(string $icon, $extraClasses = false);
	public function renderSvgIcon(string $icon, $extraClasses = false);

}
