<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;
use Tests\TestCase;

/**
 * @group departments
 * @group positions
 */
class DuplicatePositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected $position;

    public function setUp(): void
    {
        parent::setUp();

        $this->position = Position::factory()->create([
            'name' => 'Commanding Officer',
            'description' => 'My original description',
        ]);
    }

    /** @test **/
    public function itDuplicatesAPosition()
    {
        $position = DuplicatePosition::run($this->position, PositionData::from([
            'name' => 'Executive Officer',
            'description' => $this->position->description,
            'active' => $this->position->active,
            'available' => $this->position->available,
            'department_id' => $this->position->department_id,
        ]));

        $this->assertTrue($position->exists);
        $this->assertEquals('Executive Officer', $position->name);
        $this->assertEquals('My original description', $position->description);
        $this->assertEquals($this->position->department_id, $position->department_id);
        $this->assertEquals($this->position->available, $position->available);
    }
}
