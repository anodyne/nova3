<?php

namespace Tests\Unit\Ranks\Actions;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class CreateRankItemActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateRankItem::class);
    }

    /** @test **/
    public function itCreatesARankItem()
    {
        $group = create(RankGroup::class);
        $name = create(RankName::class);

        $data = new RankItemData;
        $data->group_id = $group->id;
        $data->name_id = $name->id;
        $data->base_image = 'base.png';
        $data->overlay_image = 'overlay.png';

        $item = $this->action->execute($data);

        $this->assertTrue($item->exists);
        $this->assertEquals('base.png', $item->base_image);
        $this->assertEquals('overlay.png', $item->overlay_image);
        $this->assertEquals($group->id, $item->group_id);
        $this->assertEquals($name->id, $item->name_id);
    }
}
