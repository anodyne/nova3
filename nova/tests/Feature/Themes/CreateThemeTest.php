<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testAUserCanViewTheCreateThemePage()
    {
        $this->signIn();

        $this->get(route('themes.create'))
            ->assertSuccessful();
    }

    public function testAUserCanCreateATheme()
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

    public function testTheThemeDirectoryIsScaffoldedWithAThemeIsCreated()
    {
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        Jobs\CreateThemeJob::dispatchNow($data);

        $this->assertCount(1, Storage::disk('themes')->directories());
    }

    public function testAnEventIsDispatchedWhenAThemeIsCreated()
    {
        Event::fake();
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        $theme = Jobs\CreateThemeJob::dispatchNow($data);

        Event::assertDispatched(Events\ThemeCreated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    public function testAThemeMustHaveANameToBeCreated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => null,
                'location' => 'some-location'
            ])
            ->assertSessionHasErrors('name');
    }

    public function testAThemeMustHaveALocationToBeCreated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'name' => 'some-name',
                'location' => null,
            ])
            ->assertSessionHasErrors('location');
    }

    public function testAThemeMustHaveAnAuthLayoutToBeCreated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'layout_auth' => null,
            ])
            ->assertSessionHasErrors('layout_auth');
    }

    public function testAThemeMustHaveAnAdminLayoutToBeCreated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'layout_admin' => null,
            ])
            ->assertSessionHasErrors('layout_admin');
    }

    public function testAThemeMustHaveAPublicLayoutToBeCreated()
    {
        Storage::fake('themes');

        $this->signIn();

        $this->from(route('themes.index'))
            ->post(route('themes.store'), [
                'layout_public' => null,
            ])
            ->assertSessionHasErrors('layout_public');
    }
}