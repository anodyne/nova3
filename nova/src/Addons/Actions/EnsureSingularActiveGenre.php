<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\BasicStatus;

class EnsureSingularActiveGenre
{
    use AsAction;

    public function handle(Addon $addon): void
    {
        DB::transaction(function () use ($addon) {
            Addon::active()->genre()->update(['status' => BasicStatus::Inactive]);

            $addon->update(['status' => BasicStatus::Active]);
        });
    }
}
