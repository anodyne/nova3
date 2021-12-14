<?php

declare(strict_types=1);

namespace Tests\Unit\Themes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Models\Theme;
use Tests\TestCase;

/**
 * @group themes
 */
class UpdateThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = Theme::factory()->create();
    }

    /** @test **/
    public function itUpdatesATheme()
    {
        $data = new ThemeData(
            name: 'Slate',
            location: 'slate',
            credits: 'Slate credits',
            preview: 'new-preview.jpg',
            active: false,
        );

        $theme = UpdateTheme::run($this->theme, $data);

        $this->assertTrue($theme->exists);
        $this->assertEquals('Slate', $theme->name);
        $this->assertEquals('slate', $theme->location);
        $this->assertEquals('Slate credits', $theme->credits);
        $this->assertEquals('new-preview.jpg', $theme->preview);
        $this->assertFalse($theme->active);
    }
}
