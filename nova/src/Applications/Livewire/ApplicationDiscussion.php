<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Discussions\Models\Discussion;
use Nova\Forms\Models\Form;

#[On('review-submitted')]
class ApplicationDiscussion extends Component
{
    #[Locked]
    public Application $application;

    public ?string $content = null;

    public function addMessage(): void
    {
        $this->discussion?->messages()->create([
            'content' => $this->content,
            'user_id' => Auth::id(),
        ]);

        $this->reset('content');
    }

    #[Computed]
    public function discussion(): ?Discussion
    {
        return $this->application->discussion;
    }

    #[Computed]
    public function messages(): ?Collection
    {
        $messages = $this->discussion?->messages()->get();

        $reviews = ApplicationReview::query()
            ->where('application_id', $this->application->id)
            ->whereNotNull('result')
            ->get();

        return $messages->concat($reviews)->sortByDesc('updated_at');
    }

    #[Computed]
    public function applicationReviewForm(): ?Form
    {
        return Form::key('applicationReview')->first();
    }

    #[Computed]
    public function hasPublishedForm(): bool
    {
        return filled($this->applicationReviewForm?->published_fields);
    }

    public function render()
    {
        return view('pages.applications.livewire.discussion', [
            'discussion' => $this->discussion,
            'messages' => $this->messages,
            'applicationReviewForm' => $this->applicationReviewForm,
            'hasPublishedForm' => $this->hasPublishedForm,
        ]);
    }
}
