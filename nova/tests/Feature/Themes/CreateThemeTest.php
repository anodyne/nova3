<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Nova\Themes\Models\Theme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Http\Requests\CreateThemeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class CreateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $disk;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');

        $this->theme = create(Theme::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheCreateThemePage()
    {
        $this->signInWithPermission('theme.create');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateTheme()
    {
        $this->signInWithPermission('theme.create');

        $this->followingRedirects();

        $response = $this->post(
            route('themes.store'),
            $theme = make(Theme::class)->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('themes', Arr::only($theme, [
            'name',
            'location'
        ]));

        $this->assertRouteUsesFormRequest(
            'themes.store',
            CreateThemeRequest::class
        );
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('theme.create');

        $this->post(route('themes.store'), make(Theme::class)->toArray());

        Event::assertDispatched(ThemeCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateThemePage()
    {
        $this->signIn();

        $response = $this->get(route('themes.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateTheme()
    {
        $this->signIn();

        $response = $this->post(
            route('themes.store'),
            make(Theme::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateThemePage()
    {
        $response = $this->getJson(route('themes.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateTheme()
    {
        $response = $this->postJson(
            route('themes.store'),
            make(Theme::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
