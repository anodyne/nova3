<?php namespace Tests\Genres;

use Nova\Genres\Position;
use Tests\DatabaseTestCase;

class PositionTest extends DatabaseTestCase
{
	protected $position;

	public function setUp()
	{
		parent::setUp();

		$this->position = create('Nova\Genres\Position');
	}

	/** @test **/
	public function it_belongs_to_a_department()
	{
		$this->assertInstanceOf('Nova\Genres\Department', $this->position->fresh()->department);
	}

	/** @test **/
	public function it_can_have_characters()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->position->characters
		);

		$character = create('Nova\Characters\Character');
		$character->positions()->save($this->position);

		$this->assertCount(1, $this->position->fresh()->characters);
	}

	/** @test **/
	public function it_can_increment_available_positions()
	{
		$this->position->addAvailableSlot();

		$this->assertEquals(2, $this->position->available);
	}

	/** @test **/
	public function it_can_decrement_available_positions()
	{
		$this->position->removeAvailableSlot();

		$this->assertEquals(0, $this->position->available);
	}

	/** @test **/
	public function it_cannot_have_availability_less_than_zero()
	{
		$this->position->removeAvailableSlot();
		$this->position->removeAvailableSlot();

		$this->assertEquals(0, $this->position->available);
	}
}
