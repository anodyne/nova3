<?php

namespace Nova\Themes;

use Nova\Pages\Page;

abstract class BaseTheme
{
    use Concerns\RendersTheme, Concerns\Icons;

    public $location;

    /**
     * Get the model for the theme.
     *
     * @return \Nova\Themes\Theme
     */
    public function getModel()
    {
        return Theme::location($this->location)->firstOrFail();
    }

    /**
     * Get the layout for a specific page.
     *
     * @param  \Nova\Pages\Page  $page
     * @return string
     */
    public function getPageLayout(Page $page)
    {
        return $this->getModel()->getLayoutForPage($page);
    }
}