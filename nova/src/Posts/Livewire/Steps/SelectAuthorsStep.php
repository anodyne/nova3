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
        if ($this->post->type->options->multipleAuthors) {
            return true;
        }

        if ($this->characters->count() > 0 || $this->users->count() > 0) {
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.posts.steps.select-authors');
    }
}
