<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\Events\ThemeUpdated;
use Illuminate\Support\Facades\Event;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    public function authorizedUserCanUpdateTheme()
    {
        $this->signInWithPermission('theme.update');

        $this->get(route('themes.edit', $this->theme))
            ->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateTheme()
    {
        $this->signIn();

        $this->get(route('themes.edit', $this->theme))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test **/
    public function guestCannotUpdateTheme()
    {
        $this->get(route('themes.edit', $this->theme))
            ->assertRedirect(route('login'));

        $this->put(route('themes.update', $this->theme), [])
            ->assertRedirect(route('login'));
    }

    /** @test **/
    public function themeCanBeUpdated()
    {
        $this->signInWithPermission('theme.update');

        $this->followingRedirects()
            ->put(route('themes.update', $this->theme), [
                'name' => 'New Name',
                'active' => (int) true,
                'location' => $this->theme->location,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('themes', [
            'id' => $this->theme->id,
            'name' => 'New Name',
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsUpdated()
    {
        Event::fake();

        $data = make(Theme::class)->toArray();

        $theme = app(UpdateTheme::class)->execute($this->theme, new ThemeData($data));

        Event::assertDispatched(ThemeUpdated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
