<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Concerns\AsAction;

class EnsureExternalContentIsPresent
{
    use AsAction;

    public function handle(): void
    {
        activity()->disableLogging();

        // Get the values from the external source
        // $ext = Http::get('');

        DB::table('external_content')->insert([
            'key' => '3.0.0',
            'value' => '3.0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cache the values

        activity()->enableLogging();
    }
}
