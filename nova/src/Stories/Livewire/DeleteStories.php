<?php

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Models\Story;

class DeleteStories extends Component
{
    public $actions;

    public $stories;

    protected $listeners = ['delete-story-toggle' => 'deleteStoryToggle'];

    public function deleteStoryToggle($value, $storyId): void
    {
        if ($value) {
            $this->trackStoryAction($storyId, 'delete');
        } else {
            $this->trackStoryAction($storyId, 'move');
        }
    }

    public function getStoriesForMovingPosts(int $storyId)
    {
        $storiesBeingDeleted = collect($this->actions)
            ->where('story.action', 'delete')
            ->map(fn ($value, $key) => $key)
            ->toArray();

        return Story::whereNotIn('id', array_merge(
            [1, $storyId],
            $storiesBeingDeleted
        ))->get();
    }

    public function getStoriesForMovingStories(int $storyId)
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

    public function trackPostsAction($id, $action, $actionId = null)
    {
        $this->actions[$id]['posts'] = [
            'action' => $action,
            'actionId' => $actionId,
        ];
    }

    public function trackStoryAction($id, $action, $actionId = null)
    {
        $this->actions[$id]['story'] = [
            'action' => $action,
            'actionId' => $actionId,
        ];

        if ($action === 'move') {
            $this->trackPostsAction($id, 'none');
        }

        if ($action === 'delete') {
            $this->trackPostsAction($id, 'delete');
        }
    }

    public function mount($stories)
    {
        $this->stories = $stories;

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

    public function render()
    {
        return view('livewire.stories.delete');
    }
}
