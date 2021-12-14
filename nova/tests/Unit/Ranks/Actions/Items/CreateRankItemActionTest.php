<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Items;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class CreateRankItemActionTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create();

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function itCreatesARankItem()
    {
        $data = new RankItemData(
            group_id: $this->group->id,
            name_id: $this->name->id,
            base_image: 'base.png',
            overlay_image: 'overlay.png',
        );

        $item = CreateRankItem::run($data);

        $this->assertTrue($item->exists);
        $this->assertEquals($this->group->id, $item->group_id);
        $this->assertEquals($this->name->id, $item->name_id);
        $this->assertEquals('base.png', $item->base_image);
        $this->assertEquals('overlay.png', $item->overlay_image);
    }
}
