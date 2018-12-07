<?php namespace Tests\Users;

use Date;
use Mail;
use Status;
use Nova\Users\User;
use Tests\DatabaseTestCase;
use Nova\Users\Mail\SendUserAccountCreatedNotification;

class ManageUsersTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = create(User::class);
	}

	/** @test **/
	public function unauthorized_users_cannot_manage_users()
	{
		$this->withExceptionHandling();

		$this->get(route('users.index'))->assertRedirect(route('login'));
		$this->get(route('users.create'))->assertRedirect(route('login'));
		$this->post(route('users.store'))->assertRedirect(route('login'));
		$this->get(route('users.edit', $this->user))->assertRedirect(route('login'));
		$this->patch(route('users.update', $this->user))->assertRedirect(route('login'));
		$this->delete(route('users.destroy', $this->user))->assertRedirect(route('login'));
		$this->patch(route('users.activate', $this->user))->assertRedirect(route('login'));
		$this->delete(route('users.deactivate', $this->user))->assertRedirect(route('login'));

		$this->signIn();

		// $this->get(route('users.index'))->assertStatus(403);
		$this->get(route('users.create'))->assertStatus(403);
		$this->post(route('users.store'))->assertStatus(403);
		$this->get(route('users.edit', $this->user))->assertStatus(403);
		$this->patch(route('users.update', $this->user))->assertStatus(403);
		// $this->patch(route('users.restore', $this->user))->assertStatus(403);
		$this->delete(route('users.destroy', $this->user))->assertStatus(403);
		$this->patch(route('users.activate', $this->user))->assertStatus(403);
		$this->delete(route('users.deactivate', $this->user))->assertStatus(403);
	}

	/** @test **/
	public function a_user_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		create('Nova\Authorize\Role', [], 3);

		$user = make(User::class, ['roles' => [1,3]]);

		$this->post(route('users.store'), $user->toArray());

		$this->assertDatabaseHas('users', ['name' => $user->name, 'email' => $user->email]);
		$this->assertDatabaseHas('users_roles', ['user_id' => 3, 'role_id' => 1]);
		$this->assertDatabaseHas('users_roles', ['user_id' => 3, 'role_id' => 3]);

		// TODO: Make sure preferences are created properly
	}

	/** @test **/
	// public function an_email_is_sent_with_the_password_when_a_user_is_created()
	// {
	// 	Mail::fake();

	// 	$admin = $this->createAdmin();

	// 	$this->signIn($admin);

	// 	$user = make(User::class, ['roles' => [1,3]]);

	// 	$this->post(route('users.store'), $user->toArray());

	// 	$createdUser = User::latest()->first();

	// 	Mail::assertSent(SendUserAccountCreatedNotification::class, function ($mail) use ($createdUser) {
	// 		return $mail->hasTo($createdUser->email);
	// 	});
	// }

	/** @test **/
	public function a_user_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$this->patch(
			route('users.update',
			[$this->user]),
			['name' => 'Jack Sparrow', 'email' => 'pirates_life_4_me@gmail.com']
		);

		$this->assertDatabaseHas('users', [
			'name' => 'Jack Sparrow',
			'email' => 'pirates_life_4_me@gmail.com'
		]);
	}

	/** @test **/
	public function a_user_can_be_deleted()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$user = create(User::class);

		$character = create('Nova\Characters\Character', ['user_id' => $user->id]);

		$userMedia = create('Nova\Media\Media', [
			'mediable_id' => $user->id,
			'mediable_type' => 'user'
		]);

		$characterMedia = create('Nova\Media\Media', ['mediable_id' => $character->id]);

		$this->delete(route('users.destroy', [$user]));

		$this->assertSoftDeleted('users', ['id' => $user->id]);
		$this->assertSoftDeleted('characters', ['id' => $character->id]);
		$this->assertDatabaseMissing('media', ['user_id' => $user->id]);
		$this->assertDatabaseMissing('media', ['character_id' => $character->id]);
		$this->assertDatabaseMissing('users_roles', ['user_id' => $user->id]);
	}

	/** @test **/
	public function a_user_can_be_restored()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$user = create(User::class, ['deleted_at' => Date::now()]);

		$this->patch(route('users.restore', [$user]));

		$this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
	}

	/**
	 * @test
	 * @coversNothing
	 */
	public function a_user_can_be_deactivated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$user = create(User::class);
		$character = create('Nova\Characters\Character', ['status' => Status::ACTIVE]);
		$character->assignToUser($user);

		$this->delete(route('users.deactivate', $user));

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
			'status' => Status::INACTIVE
		]);
		$this->assertDatabaseHas('characters', [
			'id' => $character->id,
			'status' => Status::INACTIVE
		]);
	}

	/**
	 * @test
	 * @coversNothing
	 */
	public function a_user_can_be_activated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$user = create(User::class, ['status' => Status::INACTIVE]);

		$this->patch(route('users.activate', $user));

		$this->assertDatabaseHas('users', [
			'id' => $user->id,
			'status' => Status::ACTIVE
		]);
	}

	/** @test **/
	public function user_management_has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('users.index'))->assertSuccessful();
		$this->get(route('users.create'))->assertSuccessful();
		$this->get(route('users.edit', $this->user))->assertSuccessful();
		$this->get(route('profile.show', $this->user))->assertSuccessful();
		$this->get(route('profile.edit', $admin))->assertSuccessful();
	}
}
