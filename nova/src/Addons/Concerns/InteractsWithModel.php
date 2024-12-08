<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

use Nova\Addons\Models\Addon;

trait InteractsWithModel
{
    public $name;

    public $credits;

    public $settings;

    /**
     * Get the model for the add-on.
     *
     * @return Addon
     */
    public function getModel()
    {
        return once(function () {
            return Addon::location($this->location)->firstOrFail();
        });
    }

    /**
     * Set the properties of the class from the model.
     *
     * @return \Nova\Addons\BaseAddon
     */
    public function setAddonProperties()
    {
        $this->name = $this->model->name;
        $this->credits = $this->model->credits;
        $this->settings = $this->model->settings;

        return $this;
    }
}
