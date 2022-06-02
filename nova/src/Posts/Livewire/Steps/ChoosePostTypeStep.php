<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Nova\Posts\Livewire\Concerns\HasPostType;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Spatie\LivewireWizard\Components\StepComponent;

class ChoosePostTypeStep extends StepComponent
{
    use AuthorizesRequests;
    use HasPostType;

    protected $rules = [
        'postType' => 'nullable'
    ];

    public function stepInfo(): array
    {
        return [
            'label' => 'Choose post type',
        ];
    }

    public function getPostTypesProperty(): Collection
    {
        return PostType::query()
            ->whereUserHasAccess(auth()->user())
            ->orderBySort()
            ->get();
    }

    public function render()
    {
        $this->authorize('create', Post::class);

        return view('livewire.posts.steps.choose-post-type', [
            'postTypes' => $this->postTypes,
        ]);
    }
}
