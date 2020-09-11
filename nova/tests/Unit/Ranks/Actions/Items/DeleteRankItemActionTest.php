<?php

namespace Tests\Unit\Ranks\Actions\Items;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Actions\DeleteRankItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class DeleteRankItemActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteRankItem::class);

        $this->item = RankItem::factory()->create();
    }

    /** @test **/
    public function itDeletesARankItem()
    {
        $item = $this->action->execute($this->item);

        $this->assertFalse($item->exists);
    }
}
