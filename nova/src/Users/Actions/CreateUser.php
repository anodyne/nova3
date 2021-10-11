<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\DataTransferObjects\UserData;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\User;

class CreateUser
{
    use AsAction;

    public function handle(UserData $data): User
    {
        return User::create(array_merge(
            $data->except('roles')->toArray(),
            ['status' => Active::class]
        ));
    }
}
