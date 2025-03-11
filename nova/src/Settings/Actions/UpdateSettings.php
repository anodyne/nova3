<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Bag\Bag;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;

class UpdateSettings
{
    use AsAction;

    public function handle($field, Bag $data): Settings
    {
        return tap(settings())->update([(string) $field => $data]);
    }
}
