<?php

namespace Tests\Unit\Users\Actions;

use Tests\TestCase;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Users\Actions\CreateUser;
use Nova\Users\DataTransferObjects\UserData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateUser::class);

        $this->role = factory(Role::class)->create();
    }

    /** @test **/
    public function itCreatesANewUser()
    {
        $data = new UserData;
        $data->name = 'John Public';
        $data->email = 'john@example.com';
        $data->gender = 'neutral';
        $data->roles = collect([$this->role]);

        $user = $this->action->execute($data);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue($user->hasRole($this->role->name));
    }
}
