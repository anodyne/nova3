<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testAUserCanViewTheEditThemePage()
    {
        $this->signIn();

        $this->get(route('themes.edit', $this->theme))
            ->assertSuccessful();
    }

    public function testAUserCanEditATheme()
    {
        $this->signIn();

        $this->followingRedirects()
            ->from(route('themes.edit', $this->theme))
            ->patch(route('themes.update', $this->theme), [
                'name' => 'New Name',
                'location' => $this->theme->location,
                'layout_auth' => $this->theme->layout_auth,
                'layout_admin' => $this->theme->layout_admin,
                'layout_public' => $this->theme->layout_public,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('themes', [
            'id' => $this->theme->id,
            'name' => 'New Name'
        ]);
    }

    public function testAnEventIsDispatchedWhenAThemeIsEdited()
    {
        Event::fake();

        $data = factory(Theme::class)->make()->toArray();

        $theme = Jobs\EditThemeJob::dispatchNow($this->theme, $data);

        Event::assertDispatched(Events\ThemeUpdated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    public function testAThemeMustHaveANameToBeUpdated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.update', $this->theme), [
                'name' => null,
            ])
            ->assertSessionHasErrors('name');
    }

    public function testAThemeLocationCannotBeChanged()
    {
        $this->markTestIncomplete();
    }

    public function testAThemeMustHaveAnAuthLayoutToBeUpdated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.update', $this->theme), [
                'layout_auth' => null,
            ])
            ->assertSessionHasErrors('layout_auth');
    }

    public function testAThemeMustHaveAnAdminLayoutToBeUpdated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.update', $this->theme), [
                'layout_admin' => null,
            ])
            ->assertSessionHasErrors('layout_admin');
    }

    public function testAThemeMustHaveAPublicLayoutToBeUpdated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.update', $this->theme), [
                'layout_public' => null,
            ])
            ->assertSessionHasErrors('layout_public');
    }
}