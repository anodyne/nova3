<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'nova3.test/api/version' => Http::response([
                'severity' => 'patch',
                'version' => '3.0.0-alpha13',
                'notes' => 'Sint eiusmod esse sint elit anim aliqua non ex consectetur.',
            ]),
        ]);
    }

    protected function afterRefreshingDatabase()
    {
        Artisan::call('operations:process');
    }
}
