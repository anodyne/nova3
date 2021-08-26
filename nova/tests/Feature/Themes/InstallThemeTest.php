<?php

declare(strict_types=1);

namespace Tests\Feature\Themes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

/**
 * @group themes
 */
class InstallThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $disk;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');

        $this->theme = Theme::factory()->make([
            'name' => 'Foo',
            'location' => 'foo',
        ]);
    }

    /** @test **/
    public function authorizedUserCanInstallTheme()
    {
        $this->signInWithPermission('theme.create');

        $this->disk->makeDirectory('foo');
        $this->disk->put('foo/theme.json', json_encode($this->theme->toArray()));

        $this->followingRedirects();

        $response = $this->post(route('themes.install'), [
            'theme' => $this->theme->location,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas(
            'themes',
            $this->theme->only('name', 'location')
        );
    }

    /** @test **/
    public function themeCannotBeInstalledWithoutQuickInstallFile()
    {
        $this->signInWithPermission('theme.create');

        $this->disk->makeDirectory('bar');

        $this->withoutExceptionHandling();
        $this->expectException(MissingQuickInstallFileException::class);

        $this->post(route('themes.install'), ['theme' => 'bar']);

        $this->assertDatabaseMissing('themes', [
            'location' => 'bar',
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotInstallTheme()
    {
        $this->signIn();

        $response = $this->post(route('themes.install'), [
            'theme' => $this->theme->location,
        ]);
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotInstallTheme()
    {
        $response = $this->postJson(route('themes.install'), [
            'theme' => $this->theme->location,
        ]);
        $response->assertUnauthorized();
    }
}
