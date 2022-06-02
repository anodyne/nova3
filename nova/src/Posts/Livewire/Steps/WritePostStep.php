<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
    use WritesPost;

    protected $listeners = [
        'daySelected',
        'locationSelected',
        'editorUpdated' => 'setPostContent',
        'storySelected' => 'setStory',
        'timeSelected',
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

    public function render()
    {
        return view('livewire.posts.steps.write-post');
    }
}
