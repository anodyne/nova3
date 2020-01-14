<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class MakeThemeCommandTest extends TestCase
{
    /** @test **/
    public function themeCanBeScoffolded()
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

    /** @test **/
    public function themeCanBeScaffoldedWithCustomLocation()
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

    /** @test **/
    public function themeCanBeScaffoldedWithStyleVariants()
    {
        Storage::fake('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
            '--variants' => ['blue', 'red'],
        ]);

        $files = Storage::disk('themes')->allFiles('foo');

        $this->assertContains('foo/design/variants/blue.css', $files);
        $this->assertContains('foo/design/variants/red.css', $files);
    }

    /** @test **/
    public function themeScaffoldingRequiresLocation()
    {
        Storage::fake('themes');

        $this->expectException('RuntimeException');

        Storage::disk('themes')->makeDirectory('foo');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
        ]);
    }
}
