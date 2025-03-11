<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Stories\Models\Story;

class DeleteStories extends Component
{
    public array $actions = [];

    public Collection $stories;

    #[On('deleteStoryToggle')]
    public function deleteStoryToggle($value, $storyId): void
    {
        $this->trackStoryAction($storyId, $value ? 'delete' : 'move');
    }

    public function getStoriesForMovingPosts(int $storyId): Collection
    {
        $storiesBeingDeleted = collect($this->actions)
            ->where('story.action', 'delete')
            ->map(fn ($value, $key) => $key)
            ->toArray();

        return Story::whereNotIn('id', array_merge(
            [$storyId],
            $storiesBeingDeleted
        ))->get();
    }

    public function getStoriesForMovingStories(int $storyId): Collection
    {
        $storiesBeingDeleted = collect($this->actions)
            ->where('story.action', 'delete')
            ->map(fn ($value, $key) => $key)
            ->toArray();

        return Story::whereNotIn('id', array_merge(
            [$storyId],
            $storiesBeingDeleted
        ))->get();
    }

    public function trackPostsAction($id, $action, $actionId = null): void
    {
        $this->actions[$id]['posts'] = [
            'action' => $action,
            'actionId' => $actionId,
        ];
    }

    public function trackStoryAction($id, $action, $actionId = null): void
    {
        $this->actions[$id]['story'] = [
            'action' => $action,
            'actionId' => $actionId,
        ];

        match ($action) {
            'move' => $this->trackPostsAction($id, 'none'),
            'delete' => $this->trackPostsAction($id, 'delete'),
            default => null,
        };
    }

    public function mount(Collection $stories): void
    {
        $this->stories = $stories->loadMissing('parent');

        $this->actions = $stories->mapWithKeys(function ($story) {
            return [$story->id => [
                'story' => [
                    'action' => 'delete',
                    'actionId' => null,
                ],
                'posts' => [
                    'action' => 'delete',
                    'actionId' => null,
                ],
            ]];
        })->toArray();
    }

    public function render(): View
    {
        return view('pages.stories.livewire.delete');
    }
}
