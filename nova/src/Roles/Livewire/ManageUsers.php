<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

/**
 * @property-read string $assignedUsers
 * @property-read Collection<int, User> $models
 * @property-read Collection<int, User> $users
 */
class ManageUsers extends Component
{
    /**
     * @var Collection<int, User>
     */
    public Collection $assigned;

    #[Locked]
    public ?Role $role = null;

    public ?string $selected = null;

    #[Computed]
    public function assignedUsers(): string
    {
        return $this->assigned
            ->map(fn (User $user): string => (string) $user->id)
            ->join(',');
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function models(): Collection
    {
        return User::get();
    }

    public function mount(): void
    {
        $this->assigned = $this->role->user ?? Collection::make();
    }

    public function remove(User $user): void
    {
        $this->assigned = $this->assigned->reject(
            fn (User $collectionUser): bool => $collectionUser->id === $user->id
        );

        $this->dispatch('users-updated', users: $this->assigned->pluck('id')->all());
    }

    public function render(): Factory|View
    {
        return view('pages.roles.livewire.manage-users', [
            'assignedUsers' => $this->assignedUsers,
            'models' => $this->models,
            'users' => $this->users,
        ]);
    }

    public function updatedSelected(User $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
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
