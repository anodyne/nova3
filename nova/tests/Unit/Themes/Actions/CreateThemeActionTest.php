<?php

namespace Tests\Unit\Themes\Actions;

use Tests\TestCase;
use Nova\Themes\Models\Theme;
use Nova\Themes\Actions\CreateTheme;
use Illuminate\Support\Facades\Storage;
use Nova\Themes\DataTransferObjects\ThemeData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group themes
 */
class CreateThemeActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateTheme::class);
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
}
