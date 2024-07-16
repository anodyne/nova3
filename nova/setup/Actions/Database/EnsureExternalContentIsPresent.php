<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class EnsureExternalContentIsPresent
{
    use AsAction;

    public function handle(): void
    {
        activity()->disableLogging();

        $content = Http::get('https://anodyne-productions.com/api/external-content');

        if ($content->ok()) {
            DB::table('external_content')->insert([
                'key' => '3.0.0',
                'value' => '3.0',
            ]);

            Cache::rememberForever('nova.external_content', function () {
                return DB::table('external_content')->get()->pluck('value', 'key');
            });
        }

        activity()->enableLogging();
    }
}
