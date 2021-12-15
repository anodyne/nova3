<?php

declare(strict_types=1);

namespace Tests\Unit\Departments\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\DataTransferObjects\PositionData;
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
        $position = DuplicatePosition::run($this->position, new PositionData([
            'name' => 'Executive Officer',
            'description' => $this->position->description,
            'active' => $this->position->active,
        ]));

        $this->assertTrue($position->exists);
        $this->assertEquals('Executive Officer', $position->name);
        $this->assertEquals('My original description', $position->description);
    }
}
