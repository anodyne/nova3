<?php

namespace Nova\Themes;

trait NavMain
{
	public $mainNavItemTemplate = '<a href="%2$s" class="nav-item nav-link">%1$s</a>';

	public function buildMainNavItem($text, $link)
	{
		return sprintf($this->mainNavItemTemplate, $text, $link);
	}
}
