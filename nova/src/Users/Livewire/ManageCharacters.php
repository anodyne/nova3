<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

class ManageCharacters extends Component
{
    public string $search = '';

    public ?User $user = null;

    public Collection $assigned;

    public ?Character $primary = null;

    public function add(Character $character): void
    {
        $this->search = '';

        $this->assigned->push($character);
    }

    public function remove(Character $character): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Character $collectionCharacter) => $collectionCharacter->id === $character->id
        );
    }

    public function setAsPrimaryCharacter(Character $character): void
    {
        $this->primary = $character;
    }

    #[Computed]
    public function characters(): Collection
    {
        return $this->assigned;
    }

    #[Computed]
    public function searchResults(): Collection
    {
        return Character::query()
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    #[Computed]
    public function assignedCharacters(): string
    {
        return $this->assigned
            ->map(fn (Character $character) => $character->id)
            ->join(',');
    }

    #[Computed]
    public function primaryCharacter(): string
    {
        return (string) $this->primary?->id;
    }

    public function mount(): void
    {
        $this->assigned = $this->user?->characters ?? Collection::make();

        $this->primary = $this->user?->primaryCharacter->first();
    }

    public function render()
    {
        return view('pages.users.livewire.manage-characters', [
            'assignedCharacters' => $this->assignedCharacters,
            'searchResults' => $this->searchResults,
            'primaryCharacter' => $this->primaryCharacter,
            'characters' => $this->characters,
        ]);
    }
}
