<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('nova:get-timezones {token}', function (string $token) {
    $response = Http::withToken($token)
        ->get('https://api.savvycal.com/v1/time_zones');

    $collection = collect($response->json())
        ->filter(fn ($tz) => $tz['golden'])
        ->map(fn ($tz) => [
            'id' => $tz['id'],
            'name' => $tz['long_name'],
        ]);

    File::put(nova_path('timezones.json'), json_encode($collection));

    $this->info('Timezones updated');
});
