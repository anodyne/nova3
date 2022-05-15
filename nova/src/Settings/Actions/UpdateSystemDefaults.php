<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;
use Spatie\LaravelData\Data;

class UpdateSystemDefaults
{
    use AsAction;

    public function handle(Data $data): Settings
    {
        if ($data->imagePath !== null) {
            settings()->addMedia($data->imagePath)->toMediaCollection('logo');
        }

        return settings()->refresh();
    }
}
