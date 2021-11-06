<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Users\Models\User;

class AddUser extends SpotlightCommand
{
    protected string $name = 'Add User';

    protected string $description = 'Add a new user';

    protected array $synonyms = [
        'create new user', 'add user account', 'create user account',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('users.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', User::class);
    }
}
