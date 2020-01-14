<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Http\Response;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
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

    /** @test **/
    public function authorizedUserCanDeleteTheme()
    {
        $this->signInWithPermission('theme.delete');

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertSuccessful();
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteTheme()
    {
        $this->signIn();

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test **/
    public function guestCannotDeleteTheme()
    {
        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test **/
    public function themeCanBeDeleted()
    {
        $this->signInWithPermission('theme.delete');

        $this->deleteJson(route('themes.destroy', $this->theme))
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseMissing('themes', [
            'id' => $this->theme->id,
            'name' => $this->theme->name,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsDeleted()
    {
        Event::fake();

        $theme = (new DeleteTheme)->execute($this->theme);

        Event::assertDispatched(ThemeDeleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
