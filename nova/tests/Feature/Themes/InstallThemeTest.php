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

        $this->signInWithPermission('theme.create');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode($this->theme->toArray()));

        $response = $this->postJson(route('themes.install'), [
            'theme' => $this->theme->location,
        ]);
        $response->assertSuccessful();
        $response->assertJson($this->theme->toArray());

        $this->assertDatabaseHas('themes', $this->theme->only('name'));
    }

    /** @test **/
    public function unauthorizedUserCannotInstallTheme()
    {
        $this->signIn();

        $response = $this->postJson(route('themes.install'), ['theme' => 'foo']);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotInstallTheme()
    {
        $response = $this->postJson(route('themes.install'), []);
        $response->assertUnauthorized();
    }

    /** @test **/
    public function installableThemesAreShown()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $this->signInWithPermission('theme.create');

        $createData = [
            'name' => 'Foo',
            'location' => 'foo',
        ];

        factory(Theme::class)->create($createData);

        $data = [
            'name' => 'Bar',
            'location' => 'bar',
        ];

        $disk->makeDirectory('bar');
        $disk->put('bar/theme.json', json_encode($data));

        $disk->makeDirectory('foo');

        $response = $this->get(route('themes.index'));
        $response->assertViewHas('pendingThemes', collect([(object) $data]));
        $response->assertResponseMissing('pendingThemes', collect([(object) $createData]));
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
