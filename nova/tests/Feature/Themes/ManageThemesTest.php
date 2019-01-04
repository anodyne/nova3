<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    /** @test **/
    public function an_authorized_user_can_view_the_manage_themes_page()
    {
        $this->signIn();

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }

    /** @test **/
    public function a_user_can_view_the_create_theme_page()
    {
        $this->signIn();

        $this->get(route('themes.create'))
            ->assertSuccessful();
    }

    /** @test **/
    public function a_user_can_create_a_theme()
    {
        Storage::fake('themes');

        $this->signIn();

        $theme = factory(Theme::class)->make()->toArray();

        $this->followingRedirects()
            ->from(route('themes.create'))
            ->post(route('themes.store'), $theme)
            ->assertSuccessful();

        $this->assertDatabaseHas('themes', $theme);
    }

    /** @test **/
    public function the_theme_directory_is_scaffolded_when_a_theme_is_created()
    {
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        Jobs\CreateThemeJob::dispatchNow($data);

        $this->assertCount(1, Storage::disk('themes')->directories());
    }

    /** @test **/
    public function an_event_is_dispatched_when_a_theme_is_created()
    {
        Event::fake();

        $data = factory(Theme::class)->make()->toArray();

        $theme = Jobs\CreateThemeJob::dispatchNow($data);

        Event::assertDispatched(Events\ThemeCreated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    /** @test **/
    public function a_user_can_view_the_edit_theme_page()
    {
        $this->signIn();

        $this->get(route('themes.edit', $this->theme))
            ->assertSuccessful();
    }

    /** @test **/
    public function a_user_can_edit_a_theme()
    {
        $this->signIn();

        $this->followingRedirects()
            ->from(route('themes.edit', $this->theme))
            ->patch(route('themes.update', $this->theme), [
                'name' => 'New Name',
                'location' => $this->theme->location,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('themes', [
            'id' => $this->theme->id,
            'name' => 'New Name'
        ]);
    }

    /** @test **/
    public function an_event_is_dispatched_when_a_theme_is_edited()
    {
        Event::fake();

        $data = factory(Theme::class)->make()->toArray();

        $theme = Jobs\UpdateThemeJob::dispatchNow($this->theme, $data);

        Event::assertDispatched(Events\ThemeUpdated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    /** @test **/
    public function a_user_can_delete_a_theme()
    {
        $this->signIn();

        $this->from(route('themes.index'))
            ->deleteJson(route('themes.destroy', $this->theme))
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseMissing('themes', [
            'id' => $this->theme->id,
            'name' => $this->theme->name
        ]);
    }

    /** @test **/
    public function an_event_is_dispatched_when_a_theme_is_deleted()
    {
        Event::fake();

        $theme = Jobs\DeleteThemeJob::dispatchNow($this->theme);

        Event::assertDispatched(Events\ThemeDeleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    /** @test **/
    public function a_theme_must_have_a_name()
    {
        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => null,
                'location' => 'some-location'
            ])
            ->assertSessionHasErrors('name');
    }

    /** @test **/
    public function a_theme_must_have_a_location()
    {
        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => 'some-name',
                'location' => null,
            ])
            ->assertSessionHasErrors('location');
    }
}