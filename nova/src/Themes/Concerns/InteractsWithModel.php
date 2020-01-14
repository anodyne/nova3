<?php

namespace Nova\Themes\Concerns;

use Nova\Themes\Models\Theme;

trait InteractsWithModel
{
    public $name;
    public $credits;
    public $iconSet;
    public $layoutAuth;
    public $layoutAdmin;
    public $layoutPublic;
    public $layoutAuthSettings;
    public $layoutAdminSettings;
    public $layoutPublicSettings;

    /**
     * Get the model for the theme.
     *
     * @return \Nova\Themes\Models\Theme
     */
    public function getModel()
    {
        return Theme::location($this->location)->firstOrFail();
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
        $this->iconSet = $this->model->icon_set;
        $this->layoutAuth = $this->model->layout_auth;
        $this->layoutPublic = $this->model->layout_public;
        $this->layoutAdmin = $this->model->layout_admin;
        $this->layoutAuthSettings = $this->model->layout_auth_settings;
        $this->layoutPublicSettings = $this->model->layout_public_settings;
        $this->layoutAdminSettings = $this->model->layout_admin_settings;

        return $this;
    }
}