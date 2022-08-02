<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JMac\Testing\Traits\AdditionalAssertions;
use Nova\Foundation\Providers\RouteServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use AdditionalAssertions;
    use CreatesApplication;
    use CustomAssertions;
    use ManagesTestUsers;
    use TestHelpers;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->remapRouteCollection();
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
    protected function remapRouteCollection(): void
    {
        $this->app->getProvider(RouteServiceProvider::class)->map();

        $this->app['router']->getRoutes()->refreshNameLookups();
        $this->app['router']->getRoutes()->refreshActionLookups();
    }
}
