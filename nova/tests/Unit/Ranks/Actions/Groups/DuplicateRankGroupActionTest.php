<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

/**
 * @group ranks
 */
class DuplicateRankGroupActionTest extends TestCase
{
    use RefreshDatabase;

    protected $group;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = RankGroup::factory()->create([
            'name' => 'Command',
        ]);
    }

    /** @test **/
    public function itDuplicatesARankGroup()
    {
        $group = DuplicateRankGroup::run($this->group, RankGroupData::from([
            'name' => 'New Name',
        ]));

        $this->assertTrue($group->exists);
        $this->assertEquals('New Name', $group->name);
    }
}
