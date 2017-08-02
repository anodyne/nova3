<?php namespace Tests\Characters;

use Date;
use Status;
use Tests\DatabaseTestCase;
use Nova\Characters\Character;

class ManageCharactersTest extends DatabaseTestCase
{
	protected $character;

	public function setUp()
	{
		parent::setUp();

		$this->character = create('Nova\Characters\Character');
	}

	/** @test **/
	public function unauthorized_users_cannot_manage_characters()
	{
		$this->withExceptionHandling();

		$this->get(route('characters.index'))->assertRedirect(route('login'));
		$this->get(route('characters.create'))->assertRedirect(route('login'));
		$this->post(route('characters.store'))->assertRedirect(route('login'));
		$this->get(route('characters.edit', $this->character))->assertRedirect(route('login'));
		$this->patch(route('characters.update', $this->character))->assertRedirect(route('login'));
		$this->patch(route('characters.restore', $this->character))->assertRedirect(route('login'));
		$this->delete(route('characters.destroy', $this->character))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('characters.index'))->assertStatus(403);
		$this->get(route('characters.create'))->assertStatus(403);
		$this->post(route('characters.store'))->assertStatus(403);
		$this->get(route('characters.edit', $this->character))->assertStatus(403);
		$this->patch(route('characters.update', $this->character))->assertStatus(403);
		$this->patch(route('characters.restore', $this->character))->assertStatus(403);
		$this->delete(route('characters.destroy', $this->character))->assertStatus(403);
	}

	/** @test **/
	public function a_character_can_be_created()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$character = make('Nova\Characters\Character');

		$this->post(route('characters.store'), $character->toArray());

		$this->assertDatabaseHas('characters', ['name' => $character->name]);
	}

	/** @test **/
	public function a_character_can_be_updated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->patch(
			route('characters.update',
			[$this->character]),
			['name' => 'Jack Sparrow']
		);

		$this->assertDatabaseHas('characters', ['name' => 'Jack Sparrow']);
	}

	/** @test **/
	public function a_character_can_be_deleted()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$character = create('Nova\Characters\Character');

		$this->delete(route('characters.destroy', [$character]));

		$this->assertSoftDeleted('characters', ['id' => $character->id]);
	}

	/** @test **/
	public function a_character_can_be_restored()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$character = create('Nova\Characters\Character', ['deleted_at' => Date::now()]);

		$this->patch(route('characters.restore', [$character]));

		$this->assertDatabaseHas('characters', ['id' => $character->id, 'deleted_at' => null]);
	}

	/** @test **/
	public function a_character_can_be_force_deleted()
	{
		# code...
	}

	/** @test **/
	public function has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);
		
		$this->get(route('characters.index'))->assertSuccessful();
		$this->get(route('characters.create'))->assertSuccessful();
		$this->get(route('characters.edit', $this->character))->assertSuccessful();
	}
}
