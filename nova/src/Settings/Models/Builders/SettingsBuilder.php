<?php

namespace Nova\Settings\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class SettingsBuilder extends Builder
{
    public function custom(): Builder
    {
        return $this->where('key', 'custom');
    }

    public function default(): Builder
    {
        return $this->where('key', 'default');
    }
}
