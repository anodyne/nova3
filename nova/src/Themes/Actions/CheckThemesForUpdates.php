<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Themes\Models\Theme;

class CheckThemesForUpdates
{
    use AsAction;

    public function handle(): void
    {
        Theme::get()->each(function (Theme $theme) {
            $response = Http::get('https://anodyne-productions.com.test/api/addon/latest-version', [
                'exchange_identifier' => $theme->exchange_identifier,
            ]);
        });
    }
}
