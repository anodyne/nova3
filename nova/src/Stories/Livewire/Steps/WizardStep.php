<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Steps;

use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Stories\Notifications\DraftPostDiscarded;
use Nova\Stories\Wizard\Step;
use Nova\Stories\Wizard\StepStatus;

abstract class WizardStep extends Component
{
    public array $allStepsNames = [];

    public array $steps = [];

    abstract public function goToNextStep(): void;

    public function booted(): void
    {
        $currentFound = false;

        $currentStepName = app(ComponentRegistry::class)->getName(static::class);

        $this->steps = collect($this->allStepsNames)
            ->map(function (string $stepName) use (&$currentFound, $currentStepName) {
                $className = app(ComponentRegistry::class)->getClass($stepName);

                $info = (new $className)->stepInfo();

                $status = $currentFound ? StepStatus::Next : StepStatus::Previous;

                if ($stepName === $currentStepName) {
                    $currentFound = true;
                    $status = StepStatus::Current;
                }

                return new Step($stepName, $info, $status);
            })
            ->toArray();
    }

    #[Renderless]
    public function deletePost(): void
    {
        $this->authorize('delete', $this->post);

        $this->post->delete();

        Notification::make()->success()
            ->title('Post has been deleted')
            ->send();

        redirect()->route('writing-overview');
    }

    #[Renderless]
    public function discardDraft(): void
    {
        $this->authorize('discardDraft', $this->post);

        $this->post->participatingUsers->each->notify(new DraftPostDiscarded(post: $this->post, user: auth()->user()));

        $this->post->delete();

        Notification::make()->success()
            ->title('Draft has been discarded')
            ->send();

        redirect()->route('writing-overview');
    }
}
