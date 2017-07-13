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
}
