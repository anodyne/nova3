<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Themes\Models\Theme;
use Nova\Themes\Jobs\UpdateTheme;
use Nova\Themes\Events\ThemeUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testAuthorizedUserCanUpdateTheme()
    {
        $this->signInWithAbility('theme.update');

        $this->get(route('themes.edit', $this->theme))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotUpdateTheme()
    {
        $this->signIn();

        $this->get(route('themes.edit', $this->theme))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotUpdateTheme()
    {
        $this->get(route('themes.edit', $this->theme))
            ->assertRedirect(route('login'));

        $this->put(route('themes.update', $this->theme), [])
            ->assertRedirect(route('login'));
    }

    public function testThemeCanBeUpdated()
    {
        $this->signInWithAbility('theme.update');

        $this->followingRedirects()
            ->from(route('themes.edit', $this->theme))
            ->put(route('themes.update', $this->theme), [
                'name' => 'New Name',
                'location' => $this->theme->location,
                'layout_auth' => $this->theme->layout_auth,
                'layout_admin' => $this->theme->layout_admin,
                'layout_public' => $this->theme->layout_public,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('themes', [
            'id' => $this->theme->id,
            'name' => 'New Name',
        ]);
    }

    public function testEventIsDispatchedWhenThemeIsUpdated()
    {
        Event::fake();

        $data = factory(Theme::class)->make()->toArray();

        $theme = UpdateTheme::dispatchNow($this->theme, $data);

        Event::assertDispatched(ThemeUpdated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
