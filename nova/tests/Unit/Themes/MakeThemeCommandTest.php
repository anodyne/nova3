<?php

declare(strict_types=1);

namespace Tests\Unit\Themes;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

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

        $this->withoutExceptionHandling();
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
    public function itStripsUnnecessaryWhitespaceFromVariantFilenames()
    {
        $this->artisan('nova:make-theme', [
            'name' => 'Foo',
            '--variants' => ['blue', ' red', 'green ', ' purple '],
        ]);

        $files = $this->disk->allFiles('foo');

        $this->assertContains('foo/design/variants/blue.css', $files);
        $this->assertContains('foo/design/variants/red.css', $files);
        $this->assertContains('foo/design/variants/green.css', $files);
        $this->assertContains('foo/design/variants/purple.css', $files);
    }
}
