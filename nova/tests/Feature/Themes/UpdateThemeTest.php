<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Events\ThemeUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class UpdateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = create(Theme::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditThemePage()
    {
        $this->signInWithPermission('theme.update');

        $response = $this->get(route('themes.edit', $this->theme));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateTheme()
    {
        $this->signInWithPermission('theme.update');

        $this->followingRedirects();

        $response = $this->put(route('themes.update', $this->theme), [
            'name' => 'New Name',
            'active' => true,
            'location' => $this->theme->location,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('themes', [
            'id' => $this->theme->id,
            'name' => 'New Name',
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('theme.update');

        $this->put(
            route('themes.update', $this->theme),
            make(Theme::class)->toArray()
        );

        Event::assertDispatched(ThemeUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditThemePage()
    {
        $this->signIn();

        $response = $this->get(route('themes.edit', $this->theme));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateTheme()
    {
        $this->signIn();

        $response = $this->putJson(
            route('themes.update', $this->theme),
            make(Theme::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditThemePage()
    {
        $response = $this->getJson(route('themes.edit', $this->theme));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateTheme()
    {
        $response = $this->putJson(
            route('themes.update', $this->theme),
            make(Theme::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
