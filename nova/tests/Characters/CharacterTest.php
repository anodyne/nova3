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
	public function it_has_positions()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->character->positions
		);
	}

	/** @test **/
	public function it_can_have_a_rank()
	{
		$this->assertInstanceOf('Nova\Genres\Rank', $this->character->rank);
	}

	/** @test **/
	public function it_can_have_a_user()
	{
		$this->assertInstanceOf('Nova\Users\User', $this->character->user);
	}

	/** @test **/
	public function it_knows_if_its_a_primary_character()
	{
		$user = $this->character->user;

		$character = create('Nova\Characters\Character', ['user_id' => $user->id]);

		$this->assertFalse($character->isPrimaryCharacter());

		$character->setAsPrimaryCharacter();

		$this->assertTrue($character->isPrimaryCharacter());
	}

	/** @test **/
	public function it_can_make_itself_a_primary_character()
	{
		$user = $this->character->user;

		$character = create('Nova\Characters\Character', ['user_id' => $user->id]);

		$character->setAsPrimaryCharacter();

		$this->assertTrue($character->isPrimaryCharacter());
	}

	/** @test **/
	public function is_has_media()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->character->media
		);
	}
}
