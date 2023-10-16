<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Actions\SetUserCharacters;
use Nova\Users\Actions\SetUserPrimaryCharacter;
use Nova\Users\Models\User;

class ManageCharacters extends Component
{
    public string $search = '';

    public User $user;

    public function assignPrimaryCharacter(Character $character): void
    {
        SetUserPrimaryCharacter::run($this->user, $character);

        Notification::make()
            ->title('New primary character set for user')
            ->body($character->displayName.' has been set as the new primary character for '.$this->user->name)
            ->success()
            ->send();
    }

    public function assignCharacter(Character $character): void
    {
        $this->search = '';

        SetUserCharacters::run(
            $this->user,
            $this->user->characters->pluck('id')->concat([$character->id])->all()
        );

        Notification::make()
            ->title('Character assigned to user')
            ->body($character->displayName.' has been assigned to '.$this->user->name)
            ->success()
            ->send();
    }

    public function unassignCharacter($characterId): void
    {
        SetUserCharacters::run(
            $this->user,
            $this->user->characters->pluck('id')->diff($characterId)->all()
        );

        Notification::make()
            ->title('Character unassigned from user')
            ->success()
            ->send();
    }

    public function getCharactersProperty()
    {
        return $this->user->characters;
    }

    public function getFilteredCharactersProperty()
    {
        return Character::query()
            ->when(filled($this->search), fn (Builder $query) => $query->searchFor($this->search))
            ->get();
    }

    public function render()
    {
        return view('livewire.users.manage-characters', [
            'characters' => $this->characters,
            'filteredCharacters' => $this->filteredCharacters,
        ]);
    }
}
