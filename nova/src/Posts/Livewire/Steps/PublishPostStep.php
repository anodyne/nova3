<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Spatie\LivewireWizard\Components\StepComponent;

class PublishPostStep extends StepComponent
{
    public function stepInfo(): array
    {
        return [
            'label' => 'Publish post',
        ];
    }

    public function render()
    {
        return view('livewire.posts.steps.publish-post');
    }
}
