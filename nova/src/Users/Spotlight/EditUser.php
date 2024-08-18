<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Users\Models\User;

class EditUser extends SpotlightCommand
{
    protected string $name = 'Edit User';

    protected string $description = 'Edit a user';

    protected array $synonyms = [
        'update user', 'edit user account', 'update user account',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('user')
                    ->setPlaceholder('Which user do you want to edit?')
            );
    }

    public function searchUser($query)
    {
        return User::where('name', 'like', "%{$query}%")
            ->get()
            ->map(function ($user) {
                return new SpotlightSearchResult(
                    $user->id,
                    $user->name,
                    sprintf('Edit %s', $user->name)
                );
            });
    }

    public function execute(Spotlight $spotlight, User $user)
    {
        $spotlight->redirectRoute('users.edit', $user);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new User);
    }
}
