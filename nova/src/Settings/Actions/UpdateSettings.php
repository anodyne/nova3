<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;
use Spatie\LaravelData\Data;

class UpdateSettings
{
    use AsAction;

    public function handle($field, Data $data): Settings
    {
        return tap(settings())->update([(string) $field => $data]);
    }
}
