<?php namespace Tests\Users;

use Status;
use Nova\Users\User;
use Tests\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = create(User::class);
	}

	/** @test **/
	public function it_can_attach_roles()
	{
		$this->assertCount(0, $this->user->roles);

		$this->user->attachRole(create('Nova\Authorize\Role'));

		$this->assertCount(1, $this->user->fresh()->roles);
	}

	/** @test **/
	public function it_can_detach_roles()
	{
		$this->assertCount(0, $this->user->roles);

		$role = create('Nova\Authorize\Role');

		$this->user->attachRole($role);

		$this->assertCount(1, $this->user->fresh()->roles);

		$this->user->detachRole($role);

		$this->assertCount(0, $this->user->fresh()->roles);
	}

	/** @test **/
	public function it_can_have_multiple_roles()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->user->roles
		);

		$this->user->attachRole(create('Nova\Authorize\Role'));
		$this->user->attachRole(create('Nova\Authorize\Role'));

		$this->assertCount(2, $this->user->fresh()->roles);
	}

	/** @test **/
	public function it_can_verify_a_role_it_has()
	{
		$role = create('Nova\Authorize\Role');

		$this->user->attachRole($role);

		$this->assertTrue($this->user->fresh()->hasRole($role->name));
	}

	/** @test **/
	public function it_records_the_current_timestamp_when_signing_in()
	{
		$this->user->recordSignIn();

		$this->assertNotEquals(null, $this->user->last_sign_in);
	}

	/** @test **/
	public function it_hashes_plain_text_passwords()
	{
		$this->user->fill(['password' => 'password1'])->save();

		$this->assertNotEquals('password1', $this->user->fresh()->getPassword());
	}

	/** @test **/
	public function it_has_characters()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->user->characters
		);

		$character = create('Nova\Characters\Character', ['user_id' => $this->user->id]);

		$this->assertCount(1, $this->user->fresh()->characters);
	}

	/** @test **/
	public function it_can_set_its_primary_character()
	{
		$character = create('Nova\Characters\Character', ['user_id' => $this->user->id]);

		$this->user->setPrimaryCharacterAs($character);

		$this->assertEquals($this->user->fresh()->primaryCharacter->id, $character->id);
	}

	/** @test **/
	public function it_can_set_a_primary_character_when_a_primary_character_is_unassigned()
	{
		$character1 = create('Nova\Characters\Character', [
			'user_id' => $this->user->id,
			'status' => Status::ACTIVE
		]);
		$character2 = create('Nova\Characters\Character', [
			'user_id' => $this->user->id,
			'status' => Status::ACTIVE
		]);

		$this->user->setPrimaryCharacterAs($character1);

		$character1->unassignFromUser();

		$this->assertEquals($this->user->fresh()->primaryCharacter->id, $character2->id);
	}

	/** @test **/
	public function it_sets_the_primary_character_to_null()
	{
		$character = create('Nova\Characters\Character', ['user_id' => $this->user->id]);

		$this->user->setPrimaryCharacterAs($character);

		$character->unassignFromUser();

		$this->assertEquals($this->user->fresh()->primaryCharacter, null);
	}

	/** @test **/
	public function is_has_media()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->user->media
		);
	}
}
