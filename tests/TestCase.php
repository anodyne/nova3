<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase {
        migrateDatabases as baseMigrateDatabases;
    }

    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(base_path('tests/fixtures/views'));

        View::share('errors', new ViewErrorBag);

        Http::fake([
            'nova3.test/api/version' => Http::response([
                'severity' => 'patch',
                'version' => '3.0.0-alpha19',
                'notes' => 'Sint eiusmod esse sint elit anim aliqua non ex consectetur.',
            ]),
            'api.github.com/repos/anodyne/nova3/releases' => Http::response([
                [
                    'url' => 'https://api.github.com/repos/anodyne/nova3/releases/233573708',
                    'assets_url' => 'https://api.github.com/repos/anodyne/nova3/releases/233573708/assets',
                    'upload_url' => 'https://uploads.github.com/repos/anodyne/nova3/releases/233573708/assets{?name,label}',
                    'html_url' => 'https://github.com/anodyne/nova3/releases/tag/v3.0.0-alpha99',
                    'id' => 233573708,
                    'author' => [],
                    'node_id' => 'RE_kwDOAH4ArM4N7A1M',
                    'tag_name' => 'v3.0.0-alpha99',
                    'target_commitish' => 'dev',
                    'name' => '3.0.0-alpha99',
                    'draft' => false,
                    'immutable' => false,
                    'prerelease' => true,
                    'created_at' => '2025-08-01T19:48:25Z',
                    'updated_at' => '2025-08-01T19:54:41Z',
                    'published_at' => '2025-08-01T19:54:41Z',
                    'assets' => [],
                    'tarball_url' => 'https://api.github.com/repos/anodyne/nova3/tarball/v3.0.0-alpha99',
                    'zipball_url' => 'https://api.github.com/repos/anodyne/nova3/zipball/v3.0.0-alpha99',
                    'body' => 'Est ullamco dolor mollit ex eiusmod sit officia laboris non labore dolor est mollit sit. Ullamco veniam irure non esse incididunt velit mollit tempor amet eu. Ex ad incididunt id reprehenderit. In mollit id minim sint.',
                    'reactions' => [],
                ],
            ]),
        ]);
    }

    protected function migrateDatabases()
    {
        $this->baseMigrateDatabases();

        $this->artisan('migrate-data');
    }
}
