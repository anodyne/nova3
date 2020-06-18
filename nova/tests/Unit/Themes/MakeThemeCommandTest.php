<?php

namespace Tests\Unit\Themes;

use Tests\TestCase;
use RuntimeException;
use Illuminate\Support\Facades\Storage;

/**
 * @group themes
 */
class MakeThemeCommandTest extends TestCase
{
    protected $disk;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');
    }

    /** @test **/
    public function itCanScaffoldAThemeDirectory()
    {
        $this->artisan('nova:make-theme', [
            'name' => 'Foo',
        ]);

        $files = $this->disk->allFiles('foo');

        $this->assertCount(1, $this->disk->directories());
        $this->assertContains('foo/theme.json', $files);
        $this->assertContains('foo/Theme.php', $files);
        $this->assertContains('foo/design/custom.css', $files);
    }

    /** @test **/
    public function itCanScaffoldAThemeDirectoryAtACustomLocation()
    {
        $this->artisan('nova:make-theme', [
            'name' => 'Foo',
            '--location' => 'bar',
        ]);

        $directories = $this->disk->directories();

        $this->assertContains('bar', $directories);
        $this->assertNotContains('foo', $directories);
    }

    /** @test **/
    public function itCanScaffoldAThemeDirectoryWithVariantStylesheets()
    {
        $this->artisan('nova:make-theme', [
            'name' => 'Foo',
            '--variants' => ['blue', 'red'],
        ]);

        $files = $this->disk->allFiles('foo');

        $this->assertContains('foo/design/variants/blue.css', $files);
        $this->assertContains('foo/design/variants/red.css', $files);
    }

    /** @test **/
    public function itRequiresALocationToScaffoldAThemeDirectory()
    {
        $this->expectException(RuntimeException::class);

        $this->disk->makeDirectory('foo');

        $this->artisan('nova:make-theme', [
            'name' => 'Foo',
        ]);
    }
}
