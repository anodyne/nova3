<?php

declare(strict_types=1);

namespace Tests\Unit\Themes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Actions\SetupThemeDirectory;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

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
