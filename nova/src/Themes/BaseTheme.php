<?php

declare(strict_types=1);

namespace Nova\Themes;

use Nova\Themes\Concerns\HasThemeSettings;
use Nova\Themes\Concerns\InteractsWithModel;
use Nova\Themes\Concerns\RendersTheme;
use Nova\Themes\Models\Theme;
use Throwable;

abstract class BaseTheme
{
    use HasThemeSettings;
    use InteractsWithModel;
    use RendersTheme;

    public string $location;

    protected Theme $model;

    public function __construct()
    {
        try {
            $this->model = $this->getModel();

            $this->setThemeProperties();
        } catch (Throwable) {
            // Don't do anything
        }
    }
}
