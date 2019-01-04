<?php

namespace Tests;

use Nova\Foundation\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        ManagesTestUsers,
        AddsCustomAssertions;

    public function setUp()
    {
        parent::setUp();

        $this->seedDatabase();
        $this->remapRouteCollection();
        $this->setupTestResponseMacros();
    }

    /**
     * It's necessary to re-map the RouteCollection because the migrations run
     * after the RouteServiceProvider has mapped all of the routes. Re-mapping
     * ensures that all of the pages that are populated in the database end up
     * as working routes.
     *
     * Additionally, the RouteCollection name and action lookup lists are NOT
     * refreshed when the RouteCollection is re-mapped, so we have to manually
     * refresh the lists in order to be able to use named routes in our tests.
     *
     * @return void
     */
    protected function remapRouteCollection()
    {
        $this
            ->app
            ->getProvider(RouteServiceProvider::class)
            ->map();

        $this->app['router']->getRoutes()->refreshNameLookups();
        $this->app['router']->getRoutes()->refreshActionLookups();
    }

    /**
     * Production data is inserted through seeders. Since testing utilities do
     * not seed the database, we need to manually seed specific items so that
     * our tests can pass.
     *
     * @return void
     */
    protected function seedDatabase()
    {
        $this->artisan('db:seed', ['--class' => \PageSeeder::class]);
        $this->artisan('db:seed', ['--class' => \ThemeSeeder::class]);
    }
}
