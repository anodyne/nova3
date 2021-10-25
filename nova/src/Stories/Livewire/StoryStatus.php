<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Livewire\Component;
use Nova\Stories\Actions\UpdateStoryStatus;

class StoryStatus extends Component
{
    public $story;

    public function updateStatus($status, $allowPosting = true)
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->story->update(['allow_posting' => $allowPosting]);

        UpdateStoryStatus::run($this->story, $status);

        $this->dispatchBrowserEvent('toast', [
            'title' => $this->story->title . ' status updated',
            'message' => null,
        ]);
    }

    public function mount($story)
    {
        $this->story = $story->unsetRelation('children');
    }

    public function render()
    {
        return view('livewire.stories.status');
    }
}
