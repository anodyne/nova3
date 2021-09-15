<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Models\Settings;

class UpdateSettings
{
    use AsAction;

    public function handle($field, CastableDataTransferObject $data): Settings
    {
        return tap(app('nova.settings'))->update([(string) $field => $data]);
    }
}
