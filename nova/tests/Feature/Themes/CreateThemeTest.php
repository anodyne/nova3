<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    /** @test  **/
    public function authorizedUserCanCreateTheme()
    {
        Storage::fake('themes');

        $this->signInWithPermission('theme.create');

        $response = $this->get(route('themes.create'));
        $response->assertSuccessful();

        $theme = factory(Theme::class)->make()->toArray();

        $response = $this->post(route('themes.store'), $theme);
        $response->assertRedirect(route('themes.index'));

        $this->assertDatabaseHas('themes', $theme);
    }

    /** @test  **/
    public function unauthorizedUserCannotCreateTheme()
    {
        $this->signIn();

        $response = $this->get(route('themes.create'));
        $response->assertForbidden();

        $response = $this->postJson(
            route('themes.store'),
            factory(Theme::class)->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test  **/
    public function guestCannotCreateTheme()
    {
        $response = $this->get(route('themes.create'));
        $response->assertRedirect(route('login'));

        $response = $this->postJson(route('themes.store'), []);
        $response->assertUnauthorized();
    }

    /** @test  **/
    public function themeDirectoryIsScaffoldedWhenThemeIsCreated()
    {
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        app(CreateTheme::class)->execute(new ThemeData($data));

        $this->assertCount(1, Storage::disk('themes')->directories());
    }

    /** @test  **/
    public function eventIsDispatchedWhenThemeIsCreated()
    {
        Event::fake();
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        $theme = app(CreateTheme::class)->execute(new ThemeData($data));

        Event::assertDispatched(ThemeCreated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    /** @test  **/
    public function nameIsRequiredToCreateTheme()
    {
        Storage::fake('themes');

        $this->signInWithPermission('theme.create');

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => null,
                'location' => 'some-location',
            ])
            ->assertSessionHasErrors('name');
    }

    /** @test  **/
    public function locationIsRequiredToCreateTheme()
    {
        Storage::fake('themes');

        $this->signInWithPermission('theme.create');

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => 'some-name',
                'location' => null,
            ])
            ->assertSessionHasErrors('location');
    }
}
