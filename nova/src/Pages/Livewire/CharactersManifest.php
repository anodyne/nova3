<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Attributes\Computed;
use Livewire\Component;
use LogicException;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Nova\Departments\Models\Builders\PositionBuilder;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @property-read Collection<int, Character>|null $characters
 * @property-read Collection<int, Department>|null $departments
 * @property-read Collection<int, Position>|null $positions
 */
class CharactersManifest extends Component
{
    public ?string $availablePositionsStatus = null;

    public ?string $cardOrientation = 'center';

    /** @var array<int, string> */
    public array $characterOptions = [];

    public ?string $characterStatus = null;

    public ?string $characterType = null;

    /** @var array<int, array<string, mixed>> */
    public array $columns = [];

    public ?string $departmentStatus = null;

    public string $layout = 'table';

    public ?string $positionStatus = null;

    /** @var array<int, int|string> */
    public array $selectedAvailablePositions = [];

    /** @var array<int, int|string> */
    public array $selectedDepartments = [];

    /** @var array<int, int|string> */
    public array $selectedPositions = [];

    public bool $showAvailablePositions = false;

    public bool $showCharacters = false;

    public bool $showDepartments = false;

    /** @var array<int, string> */
    public array $taggedAvailablePositions = [];

    /** @var array<int, string> */
    public array $taggedDepartments = [];

    /** @var array<int, string> */
    public array $taggedPositions = [];

    /** @return Collection<int, Character>|null */
    #[Computed]
    public function characters(): ?Collection
    {
        if (! $this->showCharacters) {
            return null;
        }

        return tap(
            Character::with(['positions', 'rank.name']),
            $this->filterCharacters()
        )->get();
    }

    /** @return Collection<int, Department>|null */
    #[Computed]
    public function departments(): ?Collection
    {
        if (! $this->showDepartments) {
            return null;
        }

        return Department::query()
            ->with([
                'positions' => function (Builder $query): void {
                    ($this->filterPositions())($query);

                    $query->with([
                        'characters' => function (Builder $query): void {
                            ($this->filterCharacters())($query);
                            $query->with('rank.name');
                        },
                    ]);
                },
            ])
            ->when($this->departmentStatus === 'active', fn (DepartmentBuilder $query): DepartmentBuilder => $query->active())
            ->when($this->departmentStatus === 'inactive', fn (DepartmentBuilder $query): DepartmentBuilder => $query->inactive())
            ->when($this->departmentStatus === 'choose', fn (DepartmentBuilder $query): DepartmentBuilder => $query->whereIn('id', $this->selectedDepartments))
            ->when($this->departmentStatus === 'tags', fn (DepartmentBuilder $query): DepartmentBuilder => $query->hasTags($this->taggedDepartments))
            ->whereHas('positions', $this->filterPositions())
            ->ordered()
            ->get();
    }

    public function filterCharacters(): Closure
    {
        return function (Builder $query): Builder {
            $this->characterBuilder($query)
                ->when($this->characterStatus === 'all', fn (CharacterBuilder $query): CharacterBuilder => $query->notPending())
                ->when($this->characterStatus === 'active', fn (CharacterBuilder $query): CharacterBuilder => $query->active())
                ->when($this->characterStatus === 'inactive', fn (CharacterBuilder $query): CharacterBuilder => $query->inactive())
                ->when($this->characterType === 'primary', fn (CharacterBuilder $query): CharacterBuilder => $query->primary())
                ->when($this->characterType === 'secondary', fn (CharacterBuilder $query): CharacterBuilder => $query->secondary())
                ->when($this->characterType === 'support', fn (CharacterBuilder $query): CharacterBuilder => $query->support())
                ->when($this->characterType === 'primary-secondary', fn (CharacterBuilder $query): CharacterBuilder => $query->notSupport())
                ->when($this->characterType === 'primary-support', fn (CharacterBuilder $query): CharacterBuilder => $query->notSecondary())
                ->when($this->characterType === 'secondary-support', fn (CharacterBuilder $query): CharacterBuilder => $query->notPrimary());

            return $query;
        };
    }

    public function filterPositions(): Closure
    {
        return function (Builder $query): Builder {
            $this->positionBuilder($query)
                ->when($this->positionStatus === 'active', fn (PositionBuilder $query): PositionBuilder => $query->active())
                ->when($this->positionStatus === 'inactive', fn (PositionBuilder $query): PositionBuilder => $query->inactive())
                ->when($this->positionStatus === 'choose', fn (PositionBuilder $query): PositionBuilder => $query->whereIn('id', $this->selectedPositions))
                ->when($this->positionStatus === 'tags', fn (PositionBuilder $query): PositionBuilder => $query->hasTags($this->taggedPositions))
                ->when($this->showCharacters && $this->showAvailablePositions === false, fn (PositionBuilder $query): PositionBuilder => $query->whereHas('characters', $this->filterCharacters()));

            return $query;
        };
    }

    /** @return Collection<int, Position>|null */
    #[Computed]
    public function positions(): ?Collection
    {
        if (! $this->showAvailablePositions) {
            return null;
        }

        return Position::query()
            ->available()
            ->when($this->availablePositionsStatus === 'choose', fn (PositionBuilder $query): PositionBuilder => $query->whereIn('id', $this->selectedAvailablePositions))
            ->when($this->availablePositionsStatus === 'tags', fn (PositionBuilder $query): PositionBuilder => $query->hasTags($this->taggedAvailablePositions))
            ->ordered()
            ->get();
    }

    public function render(): View
    {
        return view('pages.pages.livewire.characters-manifest', [
            'characters' => $this->characters,
            'departments' => $this->departments,
            'positions' => $this->positions,
        ]);
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

    private function characterBuilder(Builder $query): CharacterBuilder
    {
        if ($query instanceof CharacterBuilder) {
            return $query;
        }

        if ($query instanceof Relation && $query->getQuery() instanceof CharacterBuilder) {
            return $query->getQuery();
        }

        throw new LogicException('Expected a character query builder.');
    }

    private function positionBuilder(Builder $query): PositionBuilder
    {
        if ($query instanceof PositionBuilder) {
            return $query;
        }

        if ($query instanceof Relation && $query->getQuery() instanceof PositionBuilder) {
            return $query->getQuery();
        }

        throw new LogicException('Expected a position query builder.');
    }
}
