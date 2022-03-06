<?php

declare(strict_types=1);

namespace Nova\PostTypes\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\CanReorder;
use Nova\PostTypes\Actions\ReorderPostTypes;
use Nova\PostTypes\Models\PostType;

class PostTypesList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use WithPagination;

    public $search;

    public function getFilteredPostTypesProperty()
    {
        $postTypes = PostType::with('role')
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
            'postTypes' => $this->filteredPostTypes,
        ]);
    }
}
