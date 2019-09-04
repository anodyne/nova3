<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Themes\Models\Theme;
use Nova\Themes\Jobs\CreateTheme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
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

    public function testAuthorizedUserCanCreateTheme()
    {
        $this->signInWithAbility('theme.create');

        $this->get(route('themes.create'))->assertSuccessful();
    }

    public function testUnauthorizedUserCannotCreateTheme()
    {
        $this->signIn();

        $this->get(route('themes.create'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->post(route('themes.store'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotCreateTheme()
    {
        $this->get(route('themes.create'))
            ->assertRedirect(route('login'));

        $this->post(route('themes.store'), [])
            ->assertRedirect(route('login'));
    }

    public function testThemeCanBeCreated()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $theme = factory(Theme::class)->make()->toArray();

        $this->postJson(route('themes.store'), $theme)
            ->assertSuccessful()
            ->assertJson($theme);

        $this->assertDatabaseHas('themes', $theme);
    }

    public function testThemeDirectoryIsScaffoldedWhenThemeIsCreated()
    {
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        CreateTheme::dispatchNow($data);

        $this->assertCount(1, Storage::disk('themes')->directories());
    }

    public function testEventIsDispatchedWhenThemeIsCreated()
    {
        Event::fake();
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        $theme = CreateTheme::dispatchNow($data);

        Event::assertDispatched(ThemeCreated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    public function testNameIsRequiredToCreateTheme()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => null,
                'location' => 'some-location',
            ])
            ->assertSessionHasErrors('name');
    }

    public function testLocationIsRequiredToCreateTheme()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => 'some-name',
                'location' => null,
            ])
            ->assertSessionHasErrors('location');
    }
}
