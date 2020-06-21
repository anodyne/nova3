<?php

namespace Tests\Unit\Ranks\Actions;

use Tests\TestCase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\DataTransferObjects\RankGroupData;

/**
 * @group ranks
 */
class DuplicateRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateRankGroup::class);

        $this->group = create(RankGroup::class, [
            'name' => 'Command',
        ]);
    }

    /** @test **/
    public function itDuplicatesARankGroup()
    {
        $group = $this->action->execute($this->group, new RankGroupData([
            'name' => 'New Name',
        ]));

        $this->assertTrue($group->exists);
        $this->assertEquals('New Name', $group->name);
    }
}
