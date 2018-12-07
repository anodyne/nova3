<?php namespace Tests\Characters;

use Date;
use Status;
use Tests\DatabaseTestCase;
use Nova\Characters\Character;

class LinkCharactersTest extends DatabaseTestCase
{
	/** @test **/
	public function unauthorized_users_cannot_link_characters()
	{
		$this->withExceptionHandling();

		$character = create('Nova\Characters\Character');

		$this->get(route('characters.link'))->assertRedirect(route('login'));
		$this->post(route('characters.link.store'))->assertRedirect(route('login'));
		$this->patch(route('characters.link.update'))->assertRedirect(route('login'));
		$this->delete(route('characters.link.destroy', $character))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('characters.link'))->assertStatus(403);
		$this->post(route('characters.link.store'))->assertStatus(403);
		$this->patch(route('characters.link.update'))->assertStatus(403);
		$this->delete(route('characters.link.destroy', $character))->assertStatus(403);
	}

	/** @test **/
	public function character_linking_has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('characters.link'))->assertSuccessful();
	}

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

		$this->delete(route('characters.link.destroy', $character->id));

		$this->assertDatabaseMissing('characters', ['id' => $character->id, 'user_id' => $user->id]);
	}
}
