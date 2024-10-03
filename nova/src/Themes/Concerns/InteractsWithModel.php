<?php

declare(strict_types=1);

namespace Nova\Themes\Concerns;

use Nova\Themes\Models\Theme;

trait InteractsWithModel
{
    public $name;

    public $credits;

    public $layoutAuth;

    public $layoutAdmin;

    public $layoutPublic;

    public $layoutAuthSettings;

    public $layoutAdminSettings;

    public $layoutPublicSettings;

    public $settings;

    /**
     * Get the model for the theme.
     *
     * @return Theme
     */
    public function getModel()
    {
        return once(function () {
            return Theme::location($this->location)->firstOrFail();
        });
    }

    /**
     * Set the properties of the class from the model.
     *
     * @return \Nova\Themes\BaseTheme
     */
    public function setThemeProperties()
    {
        $this->name = $this->model->name;
        $this->credits = $this->model->credits;
        $this->settings = $this->model->settings;

        return $this;
    }
}
