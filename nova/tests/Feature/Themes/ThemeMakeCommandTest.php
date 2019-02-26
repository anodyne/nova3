<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ThemeMakeCommandTest extends TestCase
{
    public function testAUserCanScaffoldANewTheme()
    {
        Storage::fake('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
        ]);

        $disk = Storage::disk('themes');
        $files = $disk->allFiles('foo');

        $this->assertCount(1, $disk->directories());
        $this->assertContains('foo/theme.json', $files);
        $this->assertContains('foo/Theme.php', $files);
        $this->assertContains('foo/design/custom.css', $files);
    }

    public function testAUserCanScaffoldANewThemeWithACustomLocation()
    {
        Storage::fake('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
            '--location' => 'bar',
        ]);

        $directories = Storage::disk('themes')->directories();

        $this->assertContains('bar', $directories);
        $this->assertNotContains('foo', $directories);
    }

    public function testAUserCanScaffoldANewThemeWithVariants()
    {
        Storage::fake('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
            '--variants' => ['blue', 'red']
        ]);

        $files = Storage::disk('themes')->allFiles('foo');

        $this->assertContains('foo/design/variants/blue.css', $files);
        $this->assertContains('foo/design/variants/red.css', $files);
    }

    public function testAUserCannotScaffoldAThemeWithALocationThatExists()
    {
        Storage::fake('themes');

        $this->expectException('RuntimeException');

        Storage::disk('themes')->makeDirectory('foo');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo'
        ]);
    }
}