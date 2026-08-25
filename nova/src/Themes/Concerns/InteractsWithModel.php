<?php

declare(strict_types=1);

namespace Nova\Themes\Concerns;

use Nova\Themes\BaseTheme;
use Nova\Themes\Data\ThemeSettings;
use Nova\Themes\Models\Theme;

trait InteractsWithModel
{
    public string $name;

    public ?string $credits;

    public ?string $layoutAuth = null;

    public ?string $layoutAdmin = null;

    public ?string $layoutPublic = null;

    public ?string $layoutAuthSettings = null;

    public ?string $layoutAdminSettings = null;

    public ?string $layoutPublicSettings = null;

    public ?ThemeSettings $settings;

    public function getModel(): Theme
    {
        return once(fn () => Theme::location($this->location)->firstOrFail());
    }

    public function setThemeProperties(): BaseTheme
    {
        $this->name = $this->model->name;
        $this->credits = $this->model->credits;
        $this->settings = $this->model->settings;

        return $this;
    }
}
