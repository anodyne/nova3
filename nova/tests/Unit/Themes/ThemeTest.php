<?php

declare(strict_types=1);

namespace Tests\Unit\Themes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

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
        $disk->put('foo/theme.json', json_encode(Theme::factory()->make()));

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
        $disk->put('foo/theme.json', json_encode(Theme::factory()->make()));

        $themes = Theme::get();

        $this->assertCount(1, $themes->onlyPending());
    }
}
