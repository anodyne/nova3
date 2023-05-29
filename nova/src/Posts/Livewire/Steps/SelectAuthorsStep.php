<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Nova\Posts\Livewire\Concerns\HandlesCharacterAuthors;
use Nova\Posts\Livewire\Concerns\HandlesUserAuthors;
use Nova\Posts\Livewire\Concerns\HasAuthors;
use Nova\Posts\Livewire\Concerns\HasPost;
use Spatie\LivewireWizard\Components\StepComponent;

class SelectAuthorsStep extends StepComponent
{
    use HasPost;
    use HasAuthors;
    use HandlesCharacterAuthors;
    use HandlesUserAuthors;

    protected $listeners = [
        'selectedCharacterAuthors',
        'selectedUserAuthors',
    ];

    public function stepInfo(): array
    {
        return [
            'label' => 'Select authors',
        ];
    }

    public function getCanAddAuthorsProperty(): bool
    {
        if ($this->post->postType->options->allowsMultipleAuthors) {
            return true;
        }

        if ($this->characters->count() > 0 || $this->users->count() > 0) {
            return false;
        }

        return true;
    }

    public function getCanGoToNextStepProperty(): bool
    {
        if (
            $this->post->postType->options->allowsCharacterAuthors &&
            $this->characters->intersect(auth()->user()->characters)->count() > 0
        ) {
            return true;
        }

        if (
            $this->post->postType->options->allowsUserAuthors &&
            $this->users->contains(auth()->user())
        ) {
            return true;
        }

        return false;
    }

    public function getCanGoToNextStepMessageProperty(): string
    {
        return 'Please add one of your own characters or your user account as an author to continue.';
    }

    public function render()
    {
        return view('livewire.posts.steps.select-authors');
    }
}
