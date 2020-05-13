<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
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

        $response = $this->delete(route('themes.destroy', $this->theme));
        $response->assertRedirect(route('themes.index'));

        $this->assertDatabaseMissing('themes', $this->theme->only('id', 'name'));
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteTheme()
    {
        $this->signIn();

        $response = $this->deleteJson(route('themes.destroy', $this->theme));
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotDeleteTheme()
    {
        $response = $this->deleteJson(route('themes.destroy', $this->theme));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsDeleted()
    {
        Event::fake();

        $theme = app(DeleteTheme::class)->execute($this->theme);

        Event::assertDispatched(ThemeDeleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }
}
