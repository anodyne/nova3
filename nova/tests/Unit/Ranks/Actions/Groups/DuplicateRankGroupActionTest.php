<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Groups;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Tests\TestCase;

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

        $this->group = RankGroup::factory()->create([
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
