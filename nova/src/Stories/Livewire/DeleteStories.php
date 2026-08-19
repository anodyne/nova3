<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Stories\Models\Story;

class DeleteStories extends Component
{
    public array $actions = [];

    public Collection $stories;

    /**
     * @return Collection<int, Story>
     */
    public function getStoriesForMovingPosts(int $storyId): Collection
    {
        $storiesBeingDeleted = collect($this->actions)
            ->where('story.action', 'delete')
            ->map(fn ($value, $key) => $key)
            ->toArray();

        return Story::with('parent')
            ->whereNotIn('id', array_merge(
                [$storyId],
                $storiesBeingDeleted
            ))
            ->get();
    }

    /**
     * @return Collection<int, Story>
     */
    public function getStoriesForMovingStories(int $storyId): Collection
    {
        $storiesBeingDeleted = collect($this->actions)
            ->where('story.action', 'delete')
            ->map(fn ($value, $key) => $key)
            ->toArray();

        return Story::with('parent')
            ->whereNotIn('id', array_merge(
                [$storyId],
                $storiesBeingDeleted
            ))
            ->get();
    }

    public function mount(Collection $stories): void
    {
        $this->stories = $stories->loadMissing('parent');

        $this->actions = $stories->mapWithKeys(fn (Story $story): array => [$story->id => [
            'story' => [
                'action' => 'delete',
                'actionId' => null,
            ],
            'posts' => [
                'action' => 'delete',
                'actionId' => null,
            ],
        ]])->toArray();
    }

    public function render(): View
    {
        return view('pages.stories.livewire.delete');
    }
}
