<?php

namespace Tests\Unit\Themes\Actions;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\InstallTheme;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class InstallThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $disk;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(InstallTheme::class);

        $this->disk = Storage::fake('themes');
    }

    /** @test **/
    public function itCreatesATheme()
    {
        $data = new ThemeData;
        $data->name = 'Foo';
        $data->location = 'foo';
        $data->active = true;
        $data->preview = 'preview.jpg';

        $theme = $this->action->execute($data);

        $this->assertTrue($theme->exists);
        $this->assertEquals('Foo', $theme->name);
        $this->assertEquals('foo', $theme->location);
        $this->assertTrue($theme->active);
        $this->assertEquals('preview.jpg', $theme->preview);
    }

    /** @test **/
    public function itDoesNotCreateAThemeDirectoryWhenInstallingATheme()
    {
        $this->action->execute(new ThemeData(
            make(Theme::class)->toArray()
        ));

        $this->assertCount(0, $this->disk->directories());
    }
}
