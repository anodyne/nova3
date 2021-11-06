<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Users\Models\User;

class ViewUsers extends SpotlightCommand
{
    protected string $name = 'View Users';

    protected string $description = 'View all users';

    protected array $synonyms = [
        'show all users',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('users.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', User::class);
    }
}
