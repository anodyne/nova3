<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ThemeMakeCommandTest extends TestCase
{
    /** @test **/
    public function a_user_can_scaffold_a_new_theme()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
        ]);

        $files = $disk->allFiles('foo');

        $this->assertCount(1, $disk->directories());
        $this->assertContains('foo/theme.json', $files);
        $this->assertContains('foo/Theme.php', $files);
        $this->assertContains('foo/design/custom.css', $files);
    }

    /** @test **/
    public function a_user_can_scaffold_a_new_theme_with_a_custom_location()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
            '--location' => 'bar',
        ]);

        $directories = $disk->directories();

        $this->assertContains('bar', $directories);
        $this->assertNotContains('foo', $directories);
    }

    /** @test **/
    public function a_user_can_scaffold_a_new_theme_with_variants()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo',
            '--variants' => ['blue', 'red']
        ]);

        $files = $disk->allFiles('foo');

        $this->assertContains('foo/design/variants/blue.css', $files);
        $this->assertContains('foo/design/variants/red.css', $files);
    }

    /** @test **/
    public function a_user_cannot_scaffold_a_theme_with_a_location_that_exists()
    {
        Storage::fake('themes');

        $disk = Storage::disk('themes');

        $this->expectException('RuntimeException');

        $disk->makeDirectory('foo');

        $this->artisan('nova:make:theme', [
            'name' => 'Foo'
        ]);
    }
}