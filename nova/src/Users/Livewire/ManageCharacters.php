<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

/**
 * @property-read string $assignedCharacters
 * @property-read Collection $characters
 * @property-read Collection $models
 * @property-read string $primaryCharacter
 */
class ManageCharacters extends Component
{
    #[Locked]
    public ?User $user = null;

    public Collection $assigned;

    public ?Character $primary = null;

    public ?string $selected = null;

    public function remove(Character $character): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Character $collectionCharacter) => $collectionCharacter->id === $character->id
        );

        $this->dispatch('characters-updated', characters: $this->assigned->pluck('id')->all());
    }

    public function setAsPrimaryCharacter(Character $character): void
    {
        $this->primary = $character;
    }

    public function updatedSelected(Character $value): void
    {
        $this->assigned->push($value);

        $this->selected = null;
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
            'models' => $this->models,
            'primaryCharacter' => $this->primaryCharacter,
            'characters' => $this->characters,
        ]);
    }

    #[Computed]
    public function assignedCharacters(): string
    {
        return $this->assigned
            ->map(fn (Character $character) => $character->id)
            ->join(',');
    }

    #[Computed]
    public function characters(): Collection
    {
        return $this->assigned;
    }

    #[Computed]
    public function models(): Collection
    {
        return Character::get();
    }

    #[Computed]
    public function primaryCharacter(): string
    {
        return (string) $this->primary?->id;
    }
}
