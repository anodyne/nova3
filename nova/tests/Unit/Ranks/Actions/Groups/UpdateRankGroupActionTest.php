<?php

namespace Tests\Unit\Ranks\Actions\Groups;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class UpdateRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateRankGroup::class);

        $this->group = RankGroup::factory()->create();
    }

    /** @test **/
    public function itUpdatesARankGroup()
    {
        $data = new RankGroupData([
            'name' => 'Command',
        ]);

        $group = $this->action->execute($this->group, $data);

        $this->assertTrue($group->exists);
        $this->assertEquals('Command', $group->name);
    }
}
