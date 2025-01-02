<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('nova:refresh', function () {
    $this->call('db:wipe');
    $this->call('migrate:fresh');
    $this->call('operations:process');
    $this->call('db:seed');

    // $this->call('scout:delete-all-indexes');
    // $this->call('scout:import', ['model' => 'App\Models\Product']);
    // $this->call('scout:sync-index-settings');

    $this->call('optimize:clear');
});

Artisan::command('nova:get-timezones {token}', function (string $token) {
    $response = Http::withToken($token)
        ->get('https://api.savvycal.com/v1/time_zones');

    $collection = collect($response->json())
        ->filter(fn ($tz) => $tz['golden'])
        ->map(fn ($tz) => [
            'id' => data_get($tz, 'id'),
            'name' => sprintf(
                '(GMT%s) %s',
                data_get($tz, 'formatted_offset'),
                data_get($tz, 'long_name')
            ),
        ]);

    File::put(nova_path('timezones.json'), json_encode($collection));

    $this->info('Timezones updated');
});
