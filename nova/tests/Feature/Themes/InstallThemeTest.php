<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
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
            'location' => 'foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanInstallTheme()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode($this->theme->toArray()));

        $this->from(route('themes.index'))
            ->postJson(route('themes.install'), [
                'theme' => $this->theme->location,
            ])
            ->assertJson($this->theme->toArray());

        $this->assertDatabaseHas('themes', [
            'name' => $this->theme->name,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotInstallTheme()
    {
        $this->signIn();

        $this->postJson(route('themes.install'), ['theme' => 'foo'])
            ->assertForbidden();
    }

    /** @test **/
    public function guestCannotInstallTheme()
    {
        $this->postJson(route('themes.install'), [])
            ->assertUnauthorized();
    }

    /** @test **/
    public function installableThemesAreShown()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $createData = [
            'name' => 'Foo',
            'location' => 'foo',
        ];

        factory(Theme::class)->create($createData);

        $disk = Storage::disk('themes');

        $data = [
            'name' => 'Bar',
            'location' => 'bar',
        ];

        $disk->makeDirectory('bar');
        $disk->put('bar/theme.json', json_encode($data));

        $disk->makeDirectory('foo');

        $this->get(route('themes.index'))
            ->assertSuccessful()
            ->assertResponseHas('pendingThemes', collect([$data]))
            ->assertResponseMissing('pendingThemes', collect([$createData]));
    }

    /** @test **/
    public function themeCannotBeInstalledWithoutQuickInstallFile()
    {
        Storage::fake('themes');

        $this->signInWithAbility('theme.create');

        $disk = Storage::disk('themes');
        $disk->makeDirectory('bar');

        $this->withoutExceptionHandling();
        $this->expectException(MissingQuickInstallFileException::class);

        $this->postJson(route('themes.install'), ['theme' => 'bar']);

        $this->assertDatabaseMissing('themes', [
            'location' => 'bar',
        ]);
    }
}
