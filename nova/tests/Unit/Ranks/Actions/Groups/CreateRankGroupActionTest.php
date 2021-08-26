<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

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
        $data = new RankGroupData([
            'name' => 'Command',
        ]);

        $group = $this->action->execute($data);

        $this->assertTrue($group->exists);
        $this->assertEquals('Command', $group->name);
    }

    /** @test **/
    public function itCreatesARankGroupWithTheProperSortOrder()
    {
        RankGroup::factory()->create(['sort' => 0]);
        RankGroup::factory()->create(['sort' => 1]);

        $data = new RankGroupData([
            'name' => 'Command',
        ]);

        $group = $this->action->execute($data);

        $this->assertEquals(2, $group->sort);
    }
}
