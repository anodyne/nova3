<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Nova\Users\Actions\CreateUser;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserData;
use Tests\TestCase;

/**
 * @group users
 */
class CreateUserActionTest extends TestCase
{
    /** @test **/
    public function itCreatesANewUser()
    {
        $data = UserData::from([
            'name' => 'John Public',
            'email' => 'john@example.com',
            'pronouns' => PronounsData::from(['value' => 'neutral']),
        ]);

        $user = CreateUser::run($data);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('neutral', $user->pronouns->value);
    }
}
