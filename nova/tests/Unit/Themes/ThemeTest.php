<?php

namespace Tests\Unit\Themes;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class ThemeTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCanGetAListOfThemesToBeInstalled()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode(factory(Theme::class)->make()));

        $themes = Theme::get();

        $this->assertCount(1, $themes->onlyPending());
    }

    /** @test **/
    public function itIgnoresPendingThemesWithoutAQuickInstallFile()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $disk->makeDirectory('bar');

        $disk->makeDirectory('foo');
        $disk->put('foo/theme.json', json_encode(factory(Theme::class)->make()));

        $themes = Theme::get();

        $this->assertCount(1, $themes->onlyPending());
    }
}
