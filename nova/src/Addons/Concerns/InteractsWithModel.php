<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

use Nova\Addons\Models\Addon;

trait InteractsWithModel
{
    public $name;

    public $credits;

    public $settings;

    public function getModel(): Addon
    {
        return once(function () {
            return Addon::location($this->location)->firstOrFail();
        });
    }

    public function setAddonProperties(): self
    {
        $this->name = $this->model->name;
        $this->credits = $this->model->credits;
        $this->settings = $this->model->settings;

        return $this;
    }
}
