<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Nova\Posts\Livewire\Concerns\HasContentRatings;
use Nova\Posts\Livewire\Concerns\HasPost;
use Nova\Posts\Livewire\Concerns\HasPostType;
use Nova\Posts\Livewire\Concerns\HasStories;
use Nova\Posts\Livewire\Concerns\WritesPost;
use Spatie\LivewireWizard\Components\StepComponent;

class WritePostStep extends StepComponent
{
    use AuthorizesRequests;
    use HasPost;
    use HasPostType;
    use HasStories;
    use HasContentRatings;
    use WritesPost;

    protected $listeners = [
        'daySelected',
        'locationSelected',
        'editorUpdated' => 'setPostContent',
        'storySelected',
        'timeSelected',
        'contentRatingsUpdated',
        'authorsSelected',
    ];

    public function stepInfo(): array
    {
        return [
            'label' => 'Write your post',
        ];
    }

    protected function rules()
    {
        return $this->postType
            ->fields
            ->enabledFields()
            ->mapWithKeys(fn ($item, $key) => ["post.{$key}" => $item->required ? 'required' : 'nullable'])
            ->all();
    }

    public function goToNextStep(): void
    {
        $this->saveQuietly();

        $this->nextStep();
    }

    public function render()
    {
        return view('livewire.posts.steps.write-post');
    }
}
