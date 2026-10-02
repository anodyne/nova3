<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Bag\Bag;
use LogicException;
use Nova\Foundation\Actions\Action;
use Nova\Settings\Models\Settings;

class UpdateSettings extends Action
{
    public function handle(string $field, Bag $data): Settings
    {
        $settings = settings() ?? throw new LogicException('Settings are unavailable.');

        $settings->update([$field => $data]);

        return $settings;
    }
}
