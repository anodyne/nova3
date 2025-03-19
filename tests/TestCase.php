<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase {
        migrateDatabases as baseMigrateDatabases;
    }

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'nova3.test/api/version' => Http::response([
                'severity' => 'patch',
                'version' => '3.0.0-alpha19',
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

    protected function migrateDatabases()
    {
        $this->baseMigrateDatabases();

        $this->artisan('operations:process');
    }
}
