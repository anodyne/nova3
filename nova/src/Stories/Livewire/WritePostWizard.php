<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Mechanisms\ComponentRegistry;
use Nova\Stories\Exceptions\InvalidStepComponent;
use Nova\Stories\Exceptions\NoNextStep;
use Nova\Stories\Exceptions\NoPreviousStep;
use Nova\Stories\Exceptions\NoStepsReturned;
use Nova\Stories\Livewire\Steps\ComposePostStep;
use Nova\Stories\Livewire\Steps\PublishPostStep;
use Nova\Stories\Livewire\Steps\SetupPostStep;
use Nova\Stories\Livewire\Steps\WizardStep;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

class WritePostWizard extends WizardComponent
{
    public ?string $currentStepName = null;

    public ?Post $post = null;

    public ?int $postId = null;

    public ?PostType $postType = null;

    public ?Story $story = null;

    public function steps(): array
    {
        return [
            SetupPostStep::class,
            ComposePostStep::class,
            PublishPostStep::class,
        ];
    }

    #[On('refreshPost')]
    public function refreshPost($postId): void
    {
        $this->postId = $postId;
    }

    #[On('selectedPostType')]
    public function setPostType($postTypeId): void
    {
        $this->postType = PostType::withTrashed()->find($postTypeId);
    }

    #[On('selectedStory')]
    public function setStory($storyId): void
    {
        $this->story = Story::find($storyId);
    }

    #[On('previousStep')]
    public function previousStep(array $currentStepState = [])
    {
        $previousStep = collect($this->stepNames())
            ->before(fn (string $step) => $step === $this->currentStepName);

        if (! $previousStep) {
            throw NoPreviousStep::make(self::class, $this->currentStepName);
        }

        $this->showStep($previousStep, $currentStepState);
    }

    #[On('nextStep')]
    public function nextStep(array $currentStepState = [])
    {
        $nextStep = collect($this->stepNames())
            ->after(fn (string $step) => $step === $this->currentStepName);

        if (! $nextStep) {
            throw NoNextStep::make(self::class, $this->currentStepName);
        }

        $this->showStep($nextStep, $currentStepState);
    }

    #[On('showStep')]
    public function showStep($toStepName, array $currentStepState = [])
    {
        $this->currentStepName = $toStepName;
    }

    #[Computed]
    public function stepNames(): Collection
    {
        $steps = collect($this->steps())
            ->each(function (string $stepClassName) {
                if (! is_a($stepClassName, WizardStep::class, true)) {
                    throw InvalidStepComponent::doesNotExtendWizardStepComponent(static::class, $stepClassName);
                }
            })
            ->map(function (string $stepClassName) {
                $alias = app(ComponentRegistry::class)->getName($stepClassName);

                if (is_null($alias)) {
                    throw InvalidStepComponent::notRegisteredWithLivewire(static::class, $stepClassName);
                }

                return $alias;
            });

        if ($steps->isEmpty()) {
            throw NoStepsReturned::make(static::class);
        }

        return $steps;
    }

    public function mount(): void
    {
        $this->post = request()->route()->parameter('post');
        $this->postId = $this->post?->id;

        if ($this->post?->exists) {
            $this->postType = $this->post->postType;
            $this->story = $this->post->story;
        }

        $this->currentStepName = $this->initialStep ?? $this->stepNames->first();
    }

    public function render()
    {
        return view('pages.posts.livewire.write-post-wizard');
    }
}
