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

        $this->theme = make(Theme::class, [
            'name' => 'Foo',
            'location' => 'foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanInstallTheme()
    {
        Storage::fake('themes');

        $this->signInWithPermission('theme.create');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode($this->theme->toArray()));

        $this->followingRedirects();

        $this->postJson(route('themes.install'), [
            'theme' => $this->theme->location,
        ])
            ->assertSuccessful();

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

        $this->signInWithPermission('theme.create');

        $createData = [
            'name' => 'Foo',
            'location' => 'foo',
        ];

        create(Theme::class, $createData);

        $disk = Storage::disk('themes');

        $data = [
            'name' => 'Bar',
            'location' => 'bar',
        ];

        $disk->makeDirectory('bar');
        $disk->put('bar/theme.json', json_encode($data));

        $disk->makeDirectory('foo');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['themes']->where('name', 'Bar'));
    }

    /** @test **/
    public function themeCannotBeInstalledWithoutQuickInstallFile()
    {
        Storage::fake('themes');

        $this->signInWithPermission('theme.create');

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
