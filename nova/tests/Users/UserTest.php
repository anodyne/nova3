<?php namespace Tests\Users;

use Nova\Users\User;
use Tests\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = create('Nova\Users\User');
	}

	/** @test **/
	public function it_can_attach_roles()
	{
		$this->assertCount(0, $this->user->roles);

		$this->user->attachRole(create('Nova\Authorize\Role'));

		$this->assertCount(1, $this->user->fresh()->roles);
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
	public function it_can_verify_a_role_it_has()
	{
		$role = create('Nova\Authorize\Role');

		$this->user->attachRole($role);

		$this->assertTrue($this->user->fresh()->hasRole($role->name));
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
}
