<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class CreateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesARankName()
    {
        $data = RankNameData::from([
            'name' => 'Captain',
        ]);

        $name = CreateRankName::run($data);

        $this->assertTrue($name->exists);
        $this->assertEquals('Captain', $name->name);
    }

    /** @test **/
    public function itCreatesARankNameWithTheProperSortOrder()
    {
        RankName::factory()->create(['sort' => 0]);
        RankName::factory()->create(['sort' => 1]);

        $data = RankNameData::from([
            'name' => 'Captain',
        ]);

        $name = CreateRankName::run($data);

        $this->assertEquals(2, $name->sort);
    }
}
