<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Jobs;
use Nova\Themes\Theme;
use Nova\Themes\Events;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp()
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->create();
    }

    public function testAUserCanDeleteATheme()
    {
        $this->markTestIncomplete();

        $this->signIn();

        $this->from(route('themes.index'))
            ->deleteJson(route('themes.destroy', $this->theme))
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseMissing('themes', [
            'id' => $this->theme->id,
            'name' => $this->theme->name
        ]);
    }

    public function testAnEventIsDispatchedWhenAThemeIsDeleted()
    {
        Event::fake();

        $theme = Jobs\DeleteThemeJob::dispatchNow($this->theme);

        Event::assertDispatched(Events\ThemeDeleted::class, function ($event) use ($theme) {
            return $event->theme->is($theme);
        });
    }

    public function testAUserHasTheirThemePreferenceUpdatedWhenTheirThemeIsDeleted()
    {
        $this->markTestIncomplete();
    }
}