<?php

namespace Tests\Unit\Ranks\Actions\Items;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\UpdateRankItem;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class UpdateRankItemActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateRankItem::class);

        $this->item = create(RankItem::class);
    }

    /** @test **/
    public function itUpdatesARankItem()
    {
        $group = create(RankGroup::class);
        $name = create(RankName::class);

        $data = new RankItemData;
        $data->group_id = $group->id;
        $data->name_id = $name->id;
        $data->base_image = 'new-base.png';
        $data->overlay_image = 'new-overlay.png';

        $item = $this->action->execute($this->item, $data);

        $this->assertTrue($item->exists);
        $this->assertEquals($group->id, $item->group_id);
        $this->assertEquals($name->id, $item->name_id);
        $this->assertEquals('new-base.png', $item->base_image);
        $this->assertEquals('new-overlay.png', $item->overlay_image);
    }
}
