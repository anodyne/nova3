<?php

declare(strict_types=1);

namespace Nova\Settings\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Settings\Enums\SettingsKey;
use Nova\Settings\Models\Settings;

/**
 * @extends Builder<Settings>
 */
class SettingsBuilder extends Builder
{
    public function custom(): self
    {
        return $this->where('key', SettingsKey::Custom);
    }

    public function default(): self
    {
        return $this->where('key', SettingsKey::Default);
    }
}
