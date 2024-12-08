<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;

class CheckAddonsForUpdates
{
    use AsAction;

    public function handle(): void
    {
        Addon::get()->each(function (Addon $addon) {
            $response = Http::get('https://anodyne-productions.com.test/api/addon/latest-version', [
                'exchange_identifier' => $addon->exchange_identifier,
            ]);
        });
    }
}
