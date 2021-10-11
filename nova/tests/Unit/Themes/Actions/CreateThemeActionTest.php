<?php

declare(strict_types=1);

namespace Tests\Unit\Themes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Tests\TestCase;

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
        $data = new ThemeData([
            'name' => 'Foo',
            'location' => 'foo',
            'active' => true,
            'preview' => 'preview.jpg',
        ]);

        $theme = $this->action->execute($data);

        $this->assertTrue($theme->exists);
        $this->assertEquals('Foo', $theme->name);
        $this->assertEquals('foo', $theme->location);
        $this->assertTrue($theme->active);
        $this->assertEquals('preview.jpg', $theme->preview);
    }
}
