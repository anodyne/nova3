<?php

namespace Tests\Unit\Ranks\Actions\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DuplicateRankGroupRankItems;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankItem;

/**
 * @group ranks
 */
class DuplicateRankGroupRankItemsActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateRankGroupRankItems::class);

        $this->group = RankGroup::factory()
            ->hasRanks(2, function (array $attributes, RankGroup $group) {
                return ['group_id' => $group->id];
            })
            ->create([
                'name' => 'Command',
            ]);
    }

    /** @test **/
    public function itDuplicatesTheRankItemsFromAnotherRankGroup()
    {
        $group = app(DuplicateRankGroup::class)->execute(
            $this->group,
            new RankGroupData(['name' => 'New Name'])
        );

        $this->action->execute($group, $this->group, new RankItemData([
            'base_image' => 'new.png',
        ]));

        $group->refresh();

        $this->assertCount(2, $group->ranks);
        $this->assertEquals('new.png', $group->ranks->first()->base_image);
    }
}
