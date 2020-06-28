<?php

namespace Tests\Unit\Ranks\Actions\Groups;

use Tests\TestCase;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;

/**
 * @group ranks
 */
class CreateRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateRankGroup::class);
    }

    /** @test **/
    public function itCreatesARankGroup()
    {
        $data = new RankGroupData;
        $data->name = 'Command';

        $group = $this->action->execute($data);

        $this->assertTrue($group->exists);
        $this->assertEquals('Command', $group->name);
    }

    /** @test **/
    public function itCreatesARankGroupWithTheProperSortOrder()
    {
        create(RankGroup::class, ['sort' => 0]);
        create(RankGroup::class, ['sort' => 1]);

        $data = new RankGroupData;
        $data->name = 'Command';

        $group = $this->action->execute($data);

        $this->assertEquals(2, $group->sort);
    }
}
