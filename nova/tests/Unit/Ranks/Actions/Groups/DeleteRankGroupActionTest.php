<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DeleteRankGroup;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

/**
 * @group ranks
 */
class DeleteRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteRankGroup::class);

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function itDeletesARankGroup()
    {
        $group = $this->action->execute($this->group);

        $this->assertFalse($group->exists);
    }
}
