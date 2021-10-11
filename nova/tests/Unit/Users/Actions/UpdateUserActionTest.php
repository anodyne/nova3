<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Actions\UpdateUser;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\User;
use Tests\TestCase;

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

        $this->user = User::factory()->active()->create();
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
