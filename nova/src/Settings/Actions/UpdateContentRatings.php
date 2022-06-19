<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;
use Spatie\LaravelData\Data;

class UpdateContentRatings
{
    use AsAction;

    public function handle(Data $data): Settings
    {
        return settings()->refresh();
    }
}
