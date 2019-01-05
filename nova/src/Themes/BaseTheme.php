<?php

namespace Nova\Themes;

use Nova\Pages\Page;

abstract class BaseTheme
{
    use Concerns\RendersTheme,
        Concerns\Icons,
        Concerns\InteractsWithModel;

    public $location;

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