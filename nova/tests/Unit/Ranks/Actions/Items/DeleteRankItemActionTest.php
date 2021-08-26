<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Items;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DeleteRankItem;
use Nova\Ranks\Models\RankItem;
use Tests\TestCase;

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
