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

    protected $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->item = RankItem::factory()->create();
    }

    /** @test **/
    public function itDeletesARankItem()
    {
        $item = DeleteRankItem::run($this->item);

        $this->assertFalse($item->exists);
    }
}
