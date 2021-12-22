<?php

declare(strict_types=1);

namespace Nova\Settings;

use Nova\Settings\Data\SettingInfo;

class SettingsManager
{
    protected array $items = [];

    public function add($alias, $item): self
    {
        $this->items[$alias] = $item;

        return $this;
    }

    public function get($alias): SettingInfo
    {
        $alias = array_key_exists($alias, $this->items) ? $alias : 'general';

        return $this->items[$alias];
    }
}
