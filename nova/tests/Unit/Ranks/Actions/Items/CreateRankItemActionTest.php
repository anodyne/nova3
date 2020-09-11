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

        $this->group = RankGroup::factory()->create();

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function itCreatesARankItem()
    {
        $data = new RankItemData([
            'group_id' => $this->group->id,
            'name_id' => $this->name->id,
            'base_image' => 'base.png',
            'overlay_image' => 'overlay.png',
        ]);

        $item = $this->action->execute($data);

        $this->assertTrue($item->exists);
        $this->assertEquals($this->group->id, $item->group_id);
        $this->assertEquals($this->name->id, $item->name_id);
        $this->assertEquals('base.png', $item->base_image);
        $this->assertEquals('overlay.png', $item->overlay_image);
    }
}
