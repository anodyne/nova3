<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Users\Models\User;

class CreateUser extends SpotlightCommand
{
    protected string $name = 'Create User';

    protected string $description = 'Create a new user';

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('users.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', User::class);
    }
}
