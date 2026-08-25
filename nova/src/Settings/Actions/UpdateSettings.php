<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Bag\Bag;
use LogicException;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;

class UpdateSettings
{
    use AsAction;

    public function handle(string $field, Bag $data): Settings
    {
        $settings = settings() ?? throw new LogicException('Settings are unavailable.');

        $settings->update([$field => $data]);

        return $settings;
    }
}
