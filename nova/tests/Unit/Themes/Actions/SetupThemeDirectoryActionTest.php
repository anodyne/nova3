<?php

namespace Tests\Unit\Themes\Actions;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Themes\Actions\SetupThemeDirectory;

/**
 * @group themes
 */
class SetupThemeDirectoryActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $disk;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(SetupThemeDirectory::class);

        $this->disk = Storage::fake('themes');
    }

    /** @test **/
    public function itCreatesTheNewThemeDirectory()
    {
        $this->action->execute(new ThemeData(
            Theme::factory()->make()->toArray()
        ));

        $this->assertCount(1, $this->disk->directories());
    }
}
