<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

/**
 * @property-read string $assignedCharacters
 * @property-read Collection<int, Character> $characters
 * @property-read Collection<int, Character> $models
 * @property-read string $primaryCharacter
 */
class ManageCharacters extends Component
{
    /** @var Collection<int, Character> */
    public Collection $assigned;

    public ?Character $primary = null;

    public ?string $selected = null;

    #[Locked]
    public ?User $user = null;

    #[Computed]
    public function assignedCharacters(): string
    {
        return $this->assigned
            ->map(fn (Character $character): string => (string) $character->id)
            ->join(',');
    }

    /**
     * @return Collection<int, Character>
     */
    #[Computed]
    public function characters(): Collection
    {
        return $this->assigned;
    }

    /**
     * @return Collection<int, Character>
     */
    #[Computed]
    public function models(): Collection
    {
        return Character::get();
    }

    public function mount(): void
    {
        $this->assigned = $this->user->characters ?? Collection::make();

        $this->primary = $this->user?->primaryCharacter->first();
    }

    #[Computed]
    public function primaryCharacter(): string
    {
        return (string) $this->primary?->id;
    }

    public function remove(Character $character): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Character $collectionCharacter): bool => $collectionCharacter->id === $character->id
        );

        $this->dispatch('characters-updated', characters: $this->assigned->pluck('id')->all());
    }

    public function render(): Factory|View
    {
        return view('pages.users.livewire.manage-characters', [
            'assignedCharacters' => $this->assignedCharacters,
            'models' => $this->models,
            'primaryCharacter' => $this->primaryCharacter,
            'characters' => $this->characters,
        ]);
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
}
