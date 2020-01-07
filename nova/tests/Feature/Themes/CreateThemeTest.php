<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Events\ThemeCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
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

    /** @test  **/
    public function authorizedUserCanCreateTheme()
    {
        $this->signInWithAbility('theme.create');

        $this->get(route('themes.create'))->assertSuccessful();
    }

    /** @test  **/
    public function unauthorizedUserCannotCreateTheme()
    {
        $this->signIn();

        $this->get(route('themes.create'))
            ->assertForbidden();

        $this->post(route('themes.store'), [])
            ->assertForbidden();
    }

    /** @test  **/
    public function guestCannotCreateTheme()
    {
        $this->get(route('themes.create'))
            ->assertRedirect(route('login'));

        $this->post(route('themes.store'), [])
            ->assertRedirect(route('login'));
    }

    /** @test  **/
    public function themeCanBeCreated()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $theme = factory(Theme::class)->make()->toArray();

        $this->postJson(route('themes.store'), $theme)
            ->assertSuccessful()
            ->assertJson($theme);

        $this->assertDatabaseHas('themes', $theme);
    }

    /** @test  **/
    public function themeDirectoryIsScaffoldedWhenThemeIsCreated()
    {
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        (new CreateTheme)->execute(new ThemeData($data));

        $this->assertCount(1, Storage::disk('themes')->directories());
    }

    /** @test  **/
    public function eventIsDispatchedWhenThemeIsCreated()
    {
        Event::fake();
        Storage::fake('themes');

        $data = factory(Theme::class)->make()->toArray();

        $theme = (new CreateTheme)->execute(new ThemeData($data));

        Event::assertDispatched(ThemeCreated::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    /** @test  **/
    public function nameIsRequiredToCreateTheme()
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

    /** @test  **/
    public function locationIsRequiredToCreateTheme()
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
