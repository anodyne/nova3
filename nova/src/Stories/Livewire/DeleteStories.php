<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Stories\Models\Story;

class DeleteStories extends Component
{
    /** @var array<int, array{story: array{action: string, actionId: int|null}, posts: array{action: string, actionId: int|null}}> */
    public array $actions = [];

    /** @var Collection<int, Story> */
    public Collection $stories;

    /**
     * @return Collection<int, Story>
     */
    public function getStoriesForMovingPosts(string $storyId): Collection
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
    public function getStoriesForMovingStories(string $storyId): Collection
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
     * @param  Collection<int, Story>  $stories
     */
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
