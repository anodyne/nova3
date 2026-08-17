<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @property-read ?Collection $characters
 * @property-read ?Collection $departments
 * @property-read ?Collection $positions
 */
class CharactersManifest extends Component
{
    public string $layout = 'table';

    public bool $showCharacters = false;

    public bool $showDepartments = false;

    public bool $showAvailablePositions = false;

    public array $columns = [];

    public array $characterOptions = [];

    public ?string $cardOrientation = 'center';

    public ?string $departmentStatus = null;

    public array $selectedDepartments = [];

    public array $taggedDepartments = [];

    public ?string $positionStatus = null;

    public array $selectedPositions = [];

    public array $taggedPositions = [];

    public ?string $characterStatus = null;

    public ?string $characterType = null;

    public ?string $availablePositionsStatus = null;

    public array $selectedAvailablePositions = [];

    public array $taggedAvailablePositions = [];

    #[Computed]
    public function characters(): ?Collection
    {
        if (! $this->showCharacters) {
            return null;
        }

        return tap(
            Character::with('positions', 'rank.name'),
            $this->filterCharacters()
        )->get();
    }

    #[Computed]
    public function departments(): ?Collection
    {
        if (! $this->showDepartments) {
            return null;
        }

        return Department::query()
            ->with([
                'positions' => fn ($q) => tap($q, $this->filterPositions())->with([
                    'characters' => fn ($c) => tap($c, $this->filterCharacters())->with('rank.name'),
                ]),
            ])
            ->when($this->departmentStatus === 'active', fn ($q) => $q->active())
            ->when($this->departmentStatus === 'inactive', fn ($q) => $q->inactive())
            ->when($this->departmentStatus === 'choose', fn ($q) => $q->whereIn('id', $this->selectedDepartments))
            ->when($this->departmentStatus === 'tags', fn ($q) => $q->hasTags($this->taggedDepartments))
            ->whereHas('positions', $this->filterPositions())
            ->ordered()
            ->get();
    }

    #[Computed]
    public function positions(): ?Collection
    {
        if (! $this->showAvailablePositions) {
            return null;
        }

        return Position::query()
            ->available()
            ->when($this->availablePositionsStatus === 'choose', fn ($q) => $q->whereIn('id', $this->selectedAvailablePositions))
            ->when($this->availablePositionsStatus === 'tags', fn ($q) => $q->hasTags($this->taggedAvailablePositions))
            ->ordered()
            ->get();
    }

    public function shouldShowAvailablePosition(Position $position): bool
    {
        return $this->showAvailablePositions
            && $position->available > 0
            && $position->status === BasicStatus::Active
            && (
                $this->availablePositionsStatus === 'all' ||
                ($this->availablePositionsStatus === 'choose' && in_array($position->id, $this->selectedAvailablePositions))
            );
    }

    public function render(): View
    {
        return view('pages.pages.livewire.characters-manifest', [
            'characters' => $this->characters,
            'departments' => $this->departments,
            'positions' => $this->positions,
        ]);
    }

    public function filterPositions(): Closure
    {
        return function (Builder $query): Builder {
            return $query
                ->when($this->positionStatus === 'active', fn (Builder $q): Builder => $q->active())
                ->when($this->positionStatus === 'inactive', fn (Builder $q): Builder => $q->inactive())
                ->when($this->positionStatus === 'choose', fn (Builder $q): Builder => $q->whereIn('id', $this->selectedPositions))
                ->when($this->positionStatus === 'tags', fn (Builder $q): Builder => $q->hasTags($this->taggedPositions))
                ->when($this->showCharacters === true && $this->showAvailablePositions === false, function (Builder $q): Builder {
                    return $q->whereHas('characters', $this->filterCharacters());
                });
        };
    }

    public function filterCharacters(): Closure
    {
        return function (Builder $query): Builder {
            return $query
                ->when($this->characterStatus === 'all', fn (Builder $q): Builder => $q->notPending())
                ->when($this->characterStatus === 'active', fn (Builder $q): Builder => $q->active())
                ->when($this->characterStatus === 'inactive', fn (Builder $q): Builder => $q->inactive())
                ->when($this->characterType === 'primary', fn (Builder $q): Builder => $q->primary())
                ->when($this->characterType === 'secondary', fn (Builder $q): Builder => $q->secondary())
                ->when($this->characterType === 'support', fn (Builder $q): Builder => $q->support())
                ->when($this->characterType === 'primary-secondary', fn (Builder $q): Builder => $q->notSupport())
                ->when($this->characterType === 'primary-support', fn (Builder $q): Builder => $q->notSecondary())
                ->when($this->characterType === 'secondary-support', fn (Builder $q): Builder => $q->notPrimary());
        };
    }
}
