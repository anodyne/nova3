<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class DuplicateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = RankName::factory()->create([
            'name' => 'Captain',
        ]);
    }

    /** @test **/
    public function itDuplicatesARankName()
    {
        $name = DuplicateRankName::run($this->name);

        $this->assertTrue($name->exists);
        $this->assertEquals('Copy of Captain', $name->name);
    }
}
