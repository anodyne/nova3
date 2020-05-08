<?php

namespace Nova\Themes;

use Nova\Pages\Page;

abstract class BaseTheme
{
    use Concerns\RendersTheme,
        Concerns\InteractsWithModel;

    /**
     * The location of the theme.
     *
     * @var string
     */
    public $location;

    /**
     * The model instance for the theme.
     *
     * @var \Nova\Themes\Models\Theme
     */
    protected $model;

    public function __construct()
    {
        // $this->model = $this->getModel();

        // $this->setThemeProperties();
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
