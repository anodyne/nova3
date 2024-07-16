<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class EnsureExternalChangelogIsPresent
{
    use AsAction;

    public function handle(): void
    {
        activity()->disableLogging();

        $changelog = Http::get('https://anodyne-productions.com/api/external-changelog');

        if ($changelog->ok()) {
            DB::table('external_changelog')->insert([
                'version' => '3.0.0',
                'series' => '3.0',
                'description' => '',
                'tags' => '',
                'release_date' => now(),
            ]);
        }

        activity()->enableLogging();
    }
}
