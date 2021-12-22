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

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function itDeletesARankGroup()
    {
        $group = DeleteRankGroup::run($this->group);

        $this->assertFalse($group->exists);
    }
}
