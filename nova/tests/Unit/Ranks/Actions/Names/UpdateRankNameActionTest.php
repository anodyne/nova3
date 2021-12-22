<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class UpdateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function itUpdatesARankName()
    {
        $data = RankNameData::from([
            'name' => 'Captain',
        ]);

        $name = UpdateRankName::run($this->name, $data);

        $this->assertTrue($name->exists);
        $this->assertEquals('Captain', $name->name);
    }
}
