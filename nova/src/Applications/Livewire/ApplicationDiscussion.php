<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Forms\Models\Form;

/**
 * @property-read ?Discussion $discussion
 * @property-read Collection<int, ApplicationReview|DiscussionMessage>|null $messages
 * @property-read ?Form $applicationReviewForm
 * @property-read bool $hasPublishedForm
 */
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

        activity()
            ->performedOn($this->application)
            ->event('message-added')
            ->log('message-added');

        $this->reset('content');
    }

    #[Computed]
    public function discussion(): ?Discussion
    {
        return $this->application->discussion;
    }

    /**
     * @return Collection<int, ApplicationReview|DiscussionMessage>|null
     */
    #[Computed]
    public function messages(): ?Collection
    {
        if ($this->discussion === null) {
            return null;
        }

        $messages = $this->discussion
            ->messages()
            ->with('user')
            ->get()
            ->toBase();

        $reviews = ApplicationReview::query()
            ->with('user')
            ->where('application_id', $this->application->id)
            ->whereNotNull('result')
            ->get();

        return $messages
            ->concat($reviews)
            ->sortByDesc('updated_at');
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

    public function render(): Factory|View
    {
        return view('pages.applications.livewire.discussion', [
            'discussion' => $this->discussion,
            'messages' => $this->messages,
            'applicationReviewForm' => $this->applicationReviewForm,
            'hasPublishedForm' => $this->hasPublishedForm,
        ]);
    }
}
