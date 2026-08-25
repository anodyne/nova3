<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

/**
 * @property-read string $assignedUsers
 * @property-read Collection<int, User> $models
 * @property-read string $primaryUsers
 * @property-read Collection<int, User> $users
 */
class ManageUsers extends Component
{
    public ?Character $character = null;

    /**
     * @var Collection<int, User>
     */
    public Collection $assigned;

    /**
     * @var Collection<int, User>
     */
    public Collection $primary;

    public ?string $selected = null;

    public function remove(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser): bool => $collectionUser->id === $user->id
        );

        $this->dispatch('users-updated', users: $this->assigned->pluck('id')->all());
    }

    public function setPrimaryCharacterForUser(User $user): void
    {
        $this->primary->push($user);
    }

    public function updatedSelected(User $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
    }

    public function mount(): void
    {
        $this->assigned = $this->character->users ?? Collection::make();

        $this->primary = $this->character->primaryUsers ?? Collection::make();
    }

    public function render(): Factory|View
    {
        return view('pages.characters.livewire.manage-users', [
            'assignedUsers' => $this->assignedUsers,
            'models' => $this->models,
            'primaryUsers' => $this->primaryUsers,
            'users' => $this->users,
        ]);
    }

    #[Computed]
    public function assignedUsers(): string
    {
        return $this->assigned
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function models(): Collection
    {
        return User::query()
            ->select(['id', 'name', 'status'])
            ->get();
    }

    #[Computed]
    public function primaryUsers(): string
    {
        return $this->primary
            ->map(fn (User $user) => $user->id)
            ->join(',');
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function users(): Collection
    {
        return $this->assigned;
    }
}
