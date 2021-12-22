<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Items;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\UpdateRankItem;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class UpdateRankItemActionTest extends TestCase
{
    use RefreshDatabase;

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->item = RankItem::factory()->create();
    }

    /** @test **/
    public function itUpdatesARankItem()
    {
        $group = RankGroup::factory()->create();
        $name = RankName::factory()->create();

        $data = RankItemData::from([
            'group_id' => $group->id,
            'name_id' => $name->id,
            'base_image' => 'new-base.png',
            'overlay_image' => 'new-overlay.png',
        ]);

        $item = UpdateRankItem::run($this->item, $data);

        $this->assertTrue($item->exists);
        $this->assertEquals($group->id, $item->group_id);
        $this->assertEquals($name->id, $item->name_id);
        $this->assertEquals('new-base.png', $item->base_image);
        $this->assertEquals('new-overlay.png', $item->overlay_image);
    }
}
