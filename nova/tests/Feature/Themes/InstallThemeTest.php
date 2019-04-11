<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Theme;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;

class InstallThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = factory(Theme::class)->make([
            'name' => 'Foo',
            'location' => 'foo'
        ]);
    }

    public function testAuthorizedUserCanInstallTheme()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode($this->theme->toArray()));

        $this->from(route('themes.index'))
            ->postJson(route('themes.install'), [
                'theme' => $this->theme->location
            ])
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseHas('themes', [
            'name' => $this->theme->name
        ]);
    }

    public function testUnauthorizedUserCannotInstallTheme()
    {
        $this->signIn();

        $this->postJson(route('themes.install'), [])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestCannotInstallTheme()
    {
        $this->postJson(route('themes.install'), [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testInstallableThemesAreShown()
    {
        $this->markTestIncomplete();

        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        factory(Theme::class)->create([
            'name' => 'Bar',
            'location' => 'bar'
        ]);

        $disk = Storage::disk('themes');
        $disk->makeDirectory('bar');
        $disk->makeDirectory('foo');

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }

    public function testThemeCannotBeInstalledWithoutQuickInstallFile()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $disk = Storage::disk('themes');
        $disk->makeDirectory('bar');

        $this->withoutExceptionHandling();
        $this->expectException(MissingQuickInstallFileException::class);

        $this->postJson(route('themes.install'), ['theme' => 'bar']);

        $this->assertDatabaseMissing('themes', [
            'location' => 'bar'
        ]);
    }
}