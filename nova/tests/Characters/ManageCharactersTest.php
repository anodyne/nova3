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

		$this->get(route('characters.index'))->assertRedirect(route('sign-in'));
		$this->get(route('characters.create'))->assertRedirect(route('sign-in'));
		$this->post(route('characters.store'))->assertRedirect(route('sign-in'));
		$this->get(route('characters.edit', $this->character))->assertRedirect(route('sign-in'));
		$this->patch(route('characters.update', $this->character))->assertRedirect(route('sign-in'));
		$this->patch(route('characters.restore', $this->character))->assertRedirect(route('sign-in'));
		$this->delete(route('characters.destroy', $this->character))->assertRedirect(route('sign-in'));
		$this->patch(route('characters.activate', $this->character))->assertRedirect(route('sign-in'));
		$this->delete(route('characters.deactivate', $this->character))->assertRedirect(route('sign-in'));

		$this->signIn();

		$this->get(route('characters.index'))->assertStatus(403);
		$this->get(route('characters.create'))->assertStatus(403);
		$this->post(route('characters.store'))->assertStatus(403);
		$this->get(route('characters.edit', $this->character))->assertStatus(403);
		$this->patch(route('characters.update', $this->character))->assertStatus(403);
		$this->patch(route('characters.restore', $this->character))->assertStatus(403);
		$this->delete(route('characters.destroy', $this->character))->assertStatus(403);
		$this->patch(route('characters.activate', $this->character))->assertStatus(403);
		$this->delete(route('characters.deactivate', $this->character))->assertStatus(403);
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
	public function a_character_is_set_as_a_primary_character_when_the_user_has_no_primary_character_set()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$character = make('Nova\Characters\Character');

		$this->post(route('characters.store'), $character->toArray());

		$this->assertDatabaseHas('users', ['primary_character' => $character->id]);
	}

	/** @test **/
	public function a_character_can_be_updated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$position = create('Nova\Genres\Position');

		$this->patch(
			route('characters.update',
			[$this->character]),
			['name' => 'Jack Sparrow', 'positions' => [$position->id]]
		);

		$this->assertDatabaseHas('characters', ['name' => 'Jack Sparrow']);
	}

	/** @test **/
	public function when_a_character_is_updated_position_availability_is_updated_too()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$position1 = create('Nova\Genres\Position', ['available' => 0]);
		$position2 = create('Nova\Genres\Position', ['available' => 0]);
		$position3 = create('Nova\Genres\Position', ['available' => 1]);
		$position4 = create('Nova\Genres\Position', ['available' => 1]);

		$character = create(Character::class);
		$character->positions()->saveMany([$position1, $position2]);

		$this->patch(route('characters.update', $character->fresh()), [
			'name' => $character->name,
			'positions' => [$position3->id, $position4->id]
		]);

		$this->assertDatabaseHas('positions', ['id' => $position1->id, 'available' => 1]);
		$this->assertDatabaseHas('positions', ['id' => $position2->id, 'available' => 1]);
		$this->assertDatabaseHas('positions', ['id' => $position3->id, 'available' => 0]);
		$this->assertDatabaseHas('positions', ['id' => $position4->id, 'available' => 0]);
	}

	/** @test **/
	public function a_character_can_be_deleted()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$position1 = create('Nova\Genres\Position', ['available' => 0]);
		$position2 = create('Nova\Genres\Position', ['available' => 0]);

		$character = create('Nova\Characters\Character');
		$character->positions()->saveMany([$position1, $position2]);

		$this->delete(route('characters.destroy', [$character]));

		$this->assertSoftDeleted('characters', ['id' => $character->id]);
		$this->assertEquals(1, $position1->fresh()->available);
		$this->assertEquals(1, $position2->fresh()->available);
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

	/**
	 * @test
	 * @coversNothing
	 */
	public function a_character_can_be_deactivated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$position = create('Nova\Genres\Position', ['available' => 0]);
		$character = create(Character::class, ['status' => Status::ACTIVE]);
		$character->positions()->save($position);

		$this->delete(route('characters.deactivate', $character));

		$this->assertDatabaseHas('characters', [
			'id' => $character->id,
			'status' => Status::INACTIVE
		]);

		$this->assertDatabaseHas('positions', [
			'id' => $position->id,
			'available' => 1
		]);
	}

	/**
	 * @test
	 * @coversNothing
	 */
	public function a_character_can_be_activated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$position = create('Nova\Genres\Position', ['available' => 1]);
		$character = create(Character::class, ['status' => Status::INACTIVE]);
		$character->positions()->save($position);

		$this->patch(route('characters.activate', $character));

		$this->assertDatabaseHas('characters', [
			'id' => $character->id,
			'status' => Status::ACTIVE
		]);

		$this->assertDatabaseHas('positions', [
			'id' => $position->id,
			'available' => 0
		]);
	}

	/** @test **/
	public function character_management_has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('characters.index'))->assertSuccessful();
		$this->get(route('characters.create'))->assertSuccessful();
		$this->get(route('characters.edit', $this->character))->assertSuccessful();
		$this->get(route('characters.link'))->assertSuccessful();
	}
}
