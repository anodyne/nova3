<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Nova\Posts\Livewire\Concerns\HasPost;
use Nova\Posts\Livewire\Concerns\HasPostType;
use Nova\Posts\Livewire\Concerns\HasStories;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Spatie\LivewireWizard\Components\StepComponent;

class SetupPostStep extends StepComponent
{
    use AuthorizesRequests;
    use HasPost;
    use HasPostType;
    use HasStories;

    public function stepInfo(): array
    {
        return [
            'label' => 'Setup your post',
        ];
    }

    public function updatedStoryId($value): void
    {
        $this->setStory(Story::find($value));
    }

    public function render()
    {
        $this->authorize('create', $this->post);

        return view('livewire.posts.steps.setup-post');
    }
}
