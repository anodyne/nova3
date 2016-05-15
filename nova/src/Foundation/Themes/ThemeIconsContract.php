<?php namespace Nova\Foundation\Themes;

interface ThemeIconsContract {

	public function buildIconList($additionalClasses = false): array;
	public function getIcon(string $icon);
	public function getIconMap(): array;
	public function iconTemplate(): string;
	public function renderIcon(string $icon, $additionalClasses = false): string;

}
