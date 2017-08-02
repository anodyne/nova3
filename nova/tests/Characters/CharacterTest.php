<?php namespace Tests\Characters;

use Tests\DatabaseTestCase;
use Nova\Characters\Character;

class CharacterTest extends DatabaseTestCase
{
	protected $character;

	public function setUp()
	{
		parent::setUp();

		$this->character = create('Nova\Characters\Character');
	}

	/** @test **/
	public function it_has_a_position()
	{
		# code...
	}

	/** @test **/
	public function it_can_have_a_user()
	{
		# code...
	}
}
