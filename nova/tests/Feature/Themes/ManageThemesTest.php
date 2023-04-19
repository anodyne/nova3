<?php

declare(strict_types=1);

namespace Tests\Feature\Themes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

/**
 * @group themes
 */
class ManageThemesTest extends TestCase
{
    protected $disk;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');
    }

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.create');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.update');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.delete');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageThemesPage()
    {
        $this->signInWithPermission('theme.view');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function installableThemesAreShownWithInstalledThemes()
    {
        $this->signInWithPermission('theme.create');

        Theme::factory()->create([
            'name' => 'Foobar',
            'location' => 'foobar',
        ]);

        $this->disk->makeDirectory('bar');
        $this->disk->put('bar/theme.json', json_encode([
            'name' => 'Bar',
            'location' => 'bar',
        ]));

        $this->disk->makeDirectory('foo');

        $response = $this->get(route('themes.index'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['themes']->where('name', 'Bar'));
    }

    /** @test **/
    public function themesCanBeFilteredToShowOnlyThemesToBeInstalled()
    {
        $this->signInWithPermission('theme.create');

        Theme::factory()->create([
            'name' => 'Foobar',
            'location' => 'foobar',
        ]);

        $this->disk->makeDirectory('bar');
        $this->disk->put('bar/theme.json', json_encode([
            'name' => 'Bar',
            'location' => 'bar',
        ]));

        $response = $this->get(route('themes.index', 'pending'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['themes']->where('name', 'Bar'));
        $this->assertCount(0, $response['themes']->where('name', 'Foobar'));
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageThemesPage()
    {
        $this->signIn();

        $response = $this->get(route('themes.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageThemesPage()
    {
        $response = $this->getJson(route('themes.index'));
        $response->assertUnauthorized();
    }
}
