<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Models\Addon;

class EnsureSingularActiveGenre
{
    use AsAction;

    public function handle(Addon $addon): void
    {
        Addon::active()->genre()->update(['status' => AddonStatus::Inactive]);

        $addon->update(['status' => AddonStatus::Active]);
    }
}
