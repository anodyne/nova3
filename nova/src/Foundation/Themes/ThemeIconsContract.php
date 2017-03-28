<?php namespace Nova\Foundation\Themes;

interface ThemeIconsContract
{
	public function buildIconList($extraClasses = false): array;
	public function getIcon($icon);
	public function getIconMap();
	public function iconMap(): array;
	public function renderIcon($icon, $extraClasses = false);
	public function renderFontIcon($icon, $extraClasses = false);
	public function renderImageIcon($icon, $extraClasses = false);
	public function renderSvgIcon($icon, $extraClasses = false);
}
