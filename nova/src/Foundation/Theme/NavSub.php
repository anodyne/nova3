<?php namespace Nova\Foundation\Theme;

trait NavSub
{
	public $subNavItemTemplate = '<a href="%2$s" class="dropdown-item">%1$s</a>';

	public function buildSubNavItem($text, $link)
	{
		return sprintf($this->mainNavItemTemplate, $text, $link);
	}
}
