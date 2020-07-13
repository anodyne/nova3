<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Users\Actions\UpdateUser;
use Nova\Users\DataTransferObjects\UserData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group users
 */
class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateUser::class);

        $this->user = create(User::class, [], ['status:active']);
    }

    /** @test **/
    public function itUpdatesAUser()
    {
        $data = new UserData([
            'name' => 'John Public',
            'email' => 'john@example.com',
            'pronouns' => 'neutral',
        ]);

        $user = $this->action->execute($this->user, $data);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('neutral', $user->pronouns);
    }
}
