<?php

namespace Tests\Unit\Ranks\Actions\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DeleteRankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
