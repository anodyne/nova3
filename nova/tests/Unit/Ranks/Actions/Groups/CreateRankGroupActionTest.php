<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

/**
 * @group ranks
 */
class CreateRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesARankGroup()
    {
        $data = RankGroupData::from([
            'name' => 'Command',
        ]);

        $group = CreateRankGroup::run($data);

        $this->assertTrue($group->exists);
        $this->assertEquals('Command', $group->name);
    }

    /** @test **/
    public function itCreatesARankGroupWithTheProperSortOrder()
    {
        RankGroup::factory()->create(['sort' => 0]);
        RankGroup::factory()->create(['sort' => 1]);

        $data = RankGroupData::from([
            'name' => 'Command',
        ]);

        $group = CreateRankGroup::run($data);

        $this->assertEquals(2, $group->sort);
    }
}
