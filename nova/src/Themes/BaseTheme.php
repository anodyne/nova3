<?php

declare(strict_types=1);

namespace Nova\Themes;

use Nova\Pages\Models\Page;
use Nova\Themes\Concerns\InteractsWithModel;
use Nova\Themes\Concerns\RendersTheme;

abstract class BaseTheme
{
    use InteractsWithModel;
    use RendersTheme;

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
     *
     * @return string
     */
    public function getPageLayout(Page $page)
    {
        return $this->model->getLayoutForPage($page);
    }
}
