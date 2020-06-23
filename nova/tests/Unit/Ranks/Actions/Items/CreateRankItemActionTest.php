<?php

namespace Tests\Unit\Ranks\Actions\Items;

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

    protected $group;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateRankItem::class);

        $this->group = create(RankGroup::class);

        $this->name = create(RankName::class);
    }

    /** @test **/
    public function itCreatesARankItem()
    {
        $data = new RankItemData;
        $data->group_id = $this->group->id;
        $data->name_id = $this->name->id;
        $data->base_image = 'base.png';
        $data->overlay_image = 'overlay.png';

        $item = $this->action->execute($data);

        $this->assertTrue($item->exists);
        $this->assertEquals($this->group->id, $item->group_id);
        $this->assertEquals($this->name->id, $item->name_id);
        $this->assertEquals('base.png', $item->base_image);
        $this->assertEquals('overlay.png', $item->overlay_image);
    }
}