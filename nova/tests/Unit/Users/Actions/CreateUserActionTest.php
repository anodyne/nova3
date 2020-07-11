<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Users\Actions\CreateUser;
use Nova\Users\DataTransferObjects\UserData;

/**
 * @group users
 */
class CreateUserActionTest extends TestCase
{
    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateUser::class);
    }

    /** @test **/
    public function itCreatesANewUser()
    {
        $data = new UserData([
            'name' => 'John Public',
            'email' => 'john@example.com',
            'pronouns' => 'neutral',
        ]);

        $user = $this->action->execute($data);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('neutral', $user->pronouns);
    }
}
