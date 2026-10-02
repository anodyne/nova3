<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\Enums\BasicStatus;

class EnsureSingularActiveGenre extends Action
{
    public function handle(Addon $addon): void
    {
        DB::transaction(function () use ($addon): void {
            Addon::active()->genre()->update(['status' => BasicStatus::Inactive]);

            $addon->update(['status' => BasicStatus::Active]);
        });
    }
}
