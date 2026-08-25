<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Users\Models\User;

class ViewUser extends SpotlightCommand
{
    protected string $name = 'View User';

    protected string $description = 'View a user profile';

    /** @var list<string> */
    protected array $synonyms = [
        'show user', 'view user account', 'show user account', 'show user profile',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('user')
                    ->setPlaceholder('Which user do you want to view?')
            );
    }

    /** @return Collection<int, SpotlightSearchResult> */
    public function searchUser(string $query): Collection
    {
        return User::where('name', 'like', "%{$query}%")
            ->get()
            ->map(fn ($user): SpotlightSearchResult => new SpotlightSearchResult(
                $user->id,
                $user->name,
                sprintf('Visit %s', $user->name)
            ));
    }

    public function execute(Spotlight $spotlight, User $user): void
    {
        $spotlight->redirectRoute('admin.users.show', $user);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', User::class);
    }
}
