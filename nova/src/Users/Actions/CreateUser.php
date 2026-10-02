<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Arr;
use Nova\Foundation\Actions\Action;
use Nova\Users\Data\UserData;
use Nova\Users\Models\User;

class CreateUser extends Action
{
    public function handle(UserData $data): User
    {
        return User::create(array_merge(
            Arr::except($data->toArray(), ['roles']),
            ['force_password_reset' => false]
        ));
    }
}
