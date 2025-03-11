<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    // TODO: this can be uncommented after upgrading to Laravel 12
    // use LazilyRefreshDatabase {
    //     migrateDatabases as baseMigrateDatabases;
    // }

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

    public function createApplication()
    {
        $app = require __DIR__.'/../nova/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    // TODO: this can be uncommented after upgrading to Laravel 12
    // protected function migrateDatabases()
    // {
    //     $this->baseMigrateDatabases();

    //     $this->artisan('operations:process');
    // }
}
