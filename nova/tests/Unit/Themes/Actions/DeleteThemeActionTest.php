<?php

declare(strict_types=1);

namespace Tests\Unit\Themes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

/**
 * @group themes
 */
class DeleteThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $disk;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('themes');
        $this->disk->makeDirectory('slate');
        $this->disk->put('slate/theme.json', json_encode([
            'name' => 'Slate',
            'location' => 'slate',
        ]));

        $this->theme = Theme::factory()->create([
            'name' => 'Slate',
            'location' => 'slate',
        ]);
    }

    /** @test **/
    public function itDeletesATheme()
    {
        $theme = DeleteTheme::run($this->theme);

        $this->assertFalse($theme->exists);
    }

    /** @test **/
    public function itDoesNotRemoveTheThemeDirectoryWhenTheThemeIsDeleted()
    {
        DeleteTheme::run($this->theme);

        $this->assertCount(1, $this->disk->directories());
    }
}
