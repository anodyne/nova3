<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

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
