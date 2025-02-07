<?php

declare(strict_types=1);

namespace Nova\Themes;

use Nova\Themes\Models\Theme;
use Throwable;

abstract class BaseTheme
{
    use Concerns\HasThemeSettings;
    use Concerns\InteractsWithModel;
    use Concerns\RendersTheme;

    public string $location;

    protected Theme $model;

    public function __construct()
    {
        try {
            $this->model = $this->getModel();

            $this->setThemeProperties();
        } catch (Throwable $th) {
            // Don't do anything
        }
    }
}
