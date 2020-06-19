<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Events\ThemeDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class DeleteThemeTest extends TestCase
{
    use RefreshDatabase;

    protected $disk;

    protected $theme;

    protected $secondTheme;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');

        $this->theme = create(Theme::class);
        $this->secondTheme = create(Theme::class);
    }

    /** @test **/
    public function authorizedUserCanDeleteTheme()
    {
        $this->signInWithPermission('theme.delete');

        $this->followingRedirects();

        $response = $this->delete(route('themes.destroy', $this->theme));
        $response->assertSuccessful();

        $this->assertDatabaseMissing(
            'themes',
            $this->theme->only('name', 'location')
        );
    }

    /** @test **/
    public function theThemeDirectoryIsNotRemovedWhenAThemeIsDeleted()
    {
        $this->disk->makeDirectory($this->theme->location);

        $this->signInWithPermission('theme.delete');

        $this->delete(route('themes.destroy', $this->theme));

        $this->assertTrue(in_array(
            $this->theme->location,
            $this->disk->directories()
        ));
    }

    /** @test **/
    public function whenTheDefaultThemeIsDeletedAnotherThemeIsSetAsTheDefault()
    {
        $this->markTestSkipped('Default themes not implemented yet');

        $this->signInWithPermission('theme.delete');

        $this->delete(route('themes.destroy', $this->theme));
    }

    /** @test **/
    public function eventIsDispatchedWhenThemeIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('theme.delete');

        $this->delete(route('themes.destroy', $this->theme));

        Event::assertDispatched(ThemeDeleted::class);
    }

    /** @test **/
    public function ifThereIsOnlyOneThemeItCannotBeDeleted()
    {
        $this->signInWithPermission('theme.delete');

        Theme::where('id', '!=', $this->theme->id)->delete();

        $response = $this->delete(route('themes.destroy', $this->theme));
        $response->assertForbidden();

        $this->assertDatabaseHas(
            'themes',
            $this->theme->only('name', 'location')
        );
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteTheme()
    {
        $this->signIn();

        $response = $this->delete(route('themes.destroy', $this->theme));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteTheme()
    {
        $response = $this->deleteJson(route('themes.destroy', $this->theme));
        $response->assertUnauthorized();
    }
}
