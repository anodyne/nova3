<?php

declare(strict_types=1);

namespace Nova\Settings\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Settings\Models\Settings;

/**
 * @template TModel of Settings
 *
 * @extends Builder<TModel>
 */
class SettingsBuilder extends Builder
{
    public function custom(): self
    {
        return $this->where('key', 'custom');
    }

    public function default(): self
    {
        return $this->where('key', 'default');
    }
}
