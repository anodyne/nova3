<?php

namespace Tests\Unit\Ranks\Actions\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\DuplicateRankName;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class DuplicateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateRankName::class);

        $this->name = RankName::factory()->create([
            'name' => 'Captain',
        ]);
    }

    /** @test **/
    public function itDuplicatesARankName()
    {
        $name = $this->action->execute($this->name);

        $this->assertTrue($name->exists);
        $this->assertEquals('Copy of Captain', $name->name);
    }
}
