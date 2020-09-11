<?php

namespace Tests\Unit\Themes\Actions;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\DeleteTheme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class DeleteThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $disk;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteTheme::class);

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
        $theme = $this->action->execute($this->theme);

        $this->assertFalse($theme->exists);
    }

    /** @test **/
    public function itDoesNotRemoveTheThemeDirectoryWhenTheThemeIsDeleted()
    {
        $this->action->execute($this->theme);

        $this->assertCount(1, $this->disk->directories());
    }
}
