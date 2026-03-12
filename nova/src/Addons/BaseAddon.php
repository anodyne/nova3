<?php

declare(strict_types=1);

namespace Nova\Addons;

use Nova\Addons\Concerns\HasAddonSettings;
use Nova\Addons\Concerns\InteractsWithModel;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;

abstract class BaseAddon
{
    use HasAddonSettings;
    use InteractsWithModel;

    public string $location;

    protected Addon $model;

    public function __construct()
    {
        $this->model = $this->getModel();

        $this->setAddonProperties();
    }

    abstract public function runScript(string $name): void;

    public function isExtension(): bool
    {
        return $this->model->type === AddonType::Extension;
    }

    public function isGenre(): bool
    {
        return $this->model->type === AddonType::Genre;
    }

    public function isRankSet(): bool
    {
        return $this->model->type === AddonType::Rank;
    }
}
