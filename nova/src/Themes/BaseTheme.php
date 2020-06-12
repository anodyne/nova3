<?php

namespace Nova\Themes;

use Nova\Pages\Page;
use Nova\Themes\Concerns\RendersTheme;
use Nova\Themes\Concerns\InteractsWithModel;

abstract class BaseTheme
{
    use RendersTheme;
    use InteractsWithModel;

    /**
     * @var string
     */
    public $location;

    /**
     * @var \Nova\Themes\Models\Theme
     */
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();

        $this->setThemeProperties();
    }

    /**
     * Get the layout for a specific page.
     *
     * @param  Page  $page
     *
     * @return string
     */
    public function getPageLayout(Page $page)
    {
        return $this->model->getLayoutForPage($page);
    }
}
