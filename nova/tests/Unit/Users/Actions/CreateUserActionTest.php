<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Users\Actions\CreateUser;
use Nova\Users\DataTransferObjects\PronounsData;
use Nova\Users\DataTransferObjects\UserData;
use Tests\TestCase;

/**
 * @group users
 */
class CreateUserActionTest extends TestCase
{
    /** @test **/
    public function itCreatesANewUser()
    {
        $data = new UserData([
            'name' => 'John Public',
            'email' => 'john@example.com',
            'pronouns' => new PronounsData(value: 'neutral'),
        ]);

        $user = CreateUser::run($data);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('neutral', $user->pronouns->value);
    }
}
