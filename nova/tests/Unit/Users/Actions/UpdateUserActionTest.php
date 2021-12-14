<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Users\Actions\UpdateUser;
use Nova\Users\DataTransferObjects\PronounsData;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group users
 */
class UpdateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->active()->create();
    }

    /** @test **/
    public function itUpdatesAUser()
    {
        $data = new UserData([
            'name' => 'John Public',
            'email' => 'john@example.com',
            'pronouns' => new PronounsData(value: 'neutral'),
        ]);

        $user = UpdateUser::run($this->user, $data);

        $this->assertEquals('John Public', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('neutral', $user->pronouns->value);
    }
}
