<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \Nova\Users\Http\Controllers\ForcePasswordResetController
 */
class ForcePasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var  \Nova\Users\Models\User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
    }

    /** @test **/
    public function authorizedUserCanForcePasswordReset()
    {
        $this->signInWithPermission('user.update');

        $response = $this->put(route('users.force-password-reset', $this->user));
        $this->followRedirects($response)->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'force_password_reset' => true,
        ]);
    }

    /** @test **/
    public function authorizedUserCannotForcePasswordReset()
    {
        $this->signIn();

        $response = $this->putJson(route('users.force-password-reset', $this->user));
        $response->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'force_password_reset' => false,
        ]);
    }

    /** @test **/
    public function guestCannotForcePasswordReset()
    {
        $response = $this->putJson(route('users.force-password-reset', $this->user));
        $response->assertUnauthorized();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'force_password_reset' => false,
        ]);
    }
}
