<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Jobs;
use Nova\Themes\Events;
use Nova\Themes\Models\Theme;
use Illuminate\Http\Response;
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

        $theme = Jobs\Delete::dispatchNow($this->theme);

        Event::assertDispatched(Events\Deleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
