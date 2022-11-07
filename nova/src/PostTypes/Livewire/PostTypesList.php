<?php

declare(strict_types=1);

namespace Nova\PostTypes\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\Concerns\CanReorder;
use Nova\PostTypes\Actions\ReorderPostTypes;
use Nova\PostTypes\Models\PostType;

class PostTypesList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $statusFilter = Filter::make('status')
            ->options(
                PostType::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active', 'inactive'])
            ->meta(['label' => 'Status']);

        $requiresAccessRoleFilter = Filter::make('requires_access_role')
            ->options([
                'yes' => 'Yes',
                'no' => 'No',
            ])
            ->meta(['label' => 'Requires access role']);

        return [
            $statusFilter,
            $requiresAccessRoleFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredPostTypesProperty()
    {
        $postTypes = PostType::with('role')
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->getFilterValue('requires_access_role'), function ($query, $value) {
                return match ($value) {
                    default => $query->whereNull('role_id'),
                    'yes' => $query->whereNotNull('role_id'),
                };
            })
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $postTypes->get();
        }

        return $postTypes->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new PostType());

        ReorderPostTypes::run($items);
    }

    public function render()
    {
        return view('livewire.post-types.post-types-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'postTypeClass' => PostType::class,
            'postTypeCount' => PostType::count(),
            'postTypes' => $this->filteredPostTypes,
        ]);
    }
}
