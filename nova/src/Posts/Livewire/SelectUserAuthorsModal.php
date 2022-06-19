<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use Nova\Characters\Models\Character;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class SelectUserAuthorsModal extends ModalComponent
{
    public string $search = '';

    public array $selected = [];

    public array $selectedDisplay = [];

    public function apply(): void
    {
        $this->closeModalWithEvents([
            'posts:step:select-authors' => ['selectedUserAuthors', [
                $this->selected,
            ]],
        ]);
    }

    public function dismiss(): void
    {
        $this->closeModal();
    }

    public function getFilteredUsersProperty(): Collection
    {
        return User::query()
            ->whereActive()
            ->when($this->search, fn ($query, $search) => $query->searchFor($search))
            ->whereNotIn('id', $this->selected)
            ->get();
    }

    public function updatedSelected(): void
    {
        $this->selectedDisplay = User::query()
            ->whereIn('id', $this->selected)
            ->get()
            ->pluck('name', 'id')
            ->all();
    }

    public function render()
    {
        return view('livewire.posts.select-user-authors-modal', [
            'users' => $this->filteredUsers,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }
}
