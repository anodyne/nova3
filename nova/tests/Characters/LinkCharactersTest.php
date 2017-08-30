<?php namespace Tests\Characters;

use Date;
use Status;
use Tests\DatabaseTestCase;
use Nova\Characters\Character;

class LinkCharactersTest extends DatabaseTestCase
{
	/** @test **/
	public function a_character_can_be_assigned_to_a_user()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$user = create('Nova\Users\User');
		$character = create('Nova\Characters\Character', ['user_id' => null]);

		$this->post(route('characters.link.store'), [
			'user' => $user->id,
			'character' => $character->id
		]);

		$this->assertDatabaseHas('characters', ['id' => $character->id, 'user_id' => $user->id]);
	}

	/** @test **/
	public function a_character_can_be_unassigned_from_a_user()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$user = create('Nova\Users\User');
		$character = create('Nova\Characters\Character', ['user_id' => $user->id]);

		$this->delete(route('characters.link.destroy'), [
			'user' => $user->id,
			'character' => $character->id
		]);

		$this->assertDatabaseMissing('characters', ['id' => $character->id, 'user_id' => $user->id]);
	}
}
