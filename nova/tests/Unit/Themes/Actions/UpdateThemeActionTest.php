<?php

namespace Tests\Unit\Themes\Actions;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\UpdateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class UpdateThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $theme;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateTheme::class);

        $this->theme = create(Theme::class);
    }

    /** @test **/
    public function itUpdatesATheme()
    {
        $data = new ThemeData([
            'name' => 'Slate',
            'location' => 'slate',
            'credits' => 'Slate credits',
            'preview' => 'new-preview.jpg',
            'active' => false,
        ]);

        $theme = $this->action->execute($this->theme, $data);

        $this->assertTrue($theme->exists);
        $this->assertEquals('Slate', $theme->name);
        $this->assertEquals('slate', $theme->location);
        $this->assertEquals('Slate credits', $theme->credits);
        $this->assertEquals('new-preview.jpg', $theme->preview);
        $this->assertFalse($theme->active);
    }
}
