<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Steps;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Livewire\Concerns\HasPost;
use Nova\Posts\Livewire\Concerns\HasPostType;
use Nova\Posts\Livewire\Concerns\HasStory;
use Spatie\LivewireWizard\Components\StepComponent;

class SetupPostStep extends StepComponent
{
    use AuthorizesRequests;
    use HasPost;
    use HasPostType;
    use HasStory;

    public function stepInfo(): array
    {
        return [
            'label' => 'Setup your post',
        ];
    }

    public function goToNextStep(): void
    {
        $this->post->update([
            'direction' => request('direction'),
            'neighbor' => request('neighbor'),
        ]);

        $this->post = SetPostPosition::run(
            $this->post,
            PostPositionData::from([
                'direction' => request('direction'),
                'neighbor' => request('neighbor'),
                'hasPositionChange' => true,
            ])
        );

        $this->nextStep();
    }

    public function render()
    {
        $this->authorize('create', $this->post);

        return view('livewire.posts.steps.setup-post');
    }
}
