<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Themes\Models\Theme;
use Nova\Themes\Jobs\DeleteTheme;
use Nova\Themes\Events\ThemeDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testAuthorizedUserCanDeleteTheme()
    {
        $this->signInWithAbility('theme.delete');

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertSuccessful();
    }

    public function testUnauthorizedUserCannotDeleteTheme()
    {
        $this->signIn();

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotDeleteTheme()
    {
        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testThemeCanBeDeleted()
    {
        $this->signInWithAbility('theme.delete');

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseMissing('themes', [
            'id' => $this->theme->id,
            'name' => $this->theme->name,
        ]);
    }

    public function testEventIsDispatchedWhenThemeIsDeleted()
    {
        Event::fake();

        $theme = DeleteTheme::dispatchNow($this->theme);

        Event::assertDispatched(ThemeDeleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
