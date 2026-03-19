<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\Modal;
use Nova\Users\Models\User;

class ApplicationReviewModal extends Modal
{
    #[Locked]
    public int|Application $application;

    #[Locked]
    public int|User $user;

    #[Locked]
    public ?ApplicationReview $review;

    public ApplicationReviewForm $form;

    public array $values = [];

    public function save(): void
    {
        $this->authorize('vote', $this->application);

        $this->form->save();

        if (filled($this->applicationReviewForm->published_fields)) {
            $submission = CreateFormSubmission::run(
                form: $this->applicationReviewForm,
                owner: $this->owner,
                meta: ['application_id' => $this->application->id]
            );

            SyncFormSubmissionResponses::run($submission, $this->values);
        }

        $this->dispatch('review-submitted');

        $this->close();

        Notification::make()->success()
            ->title('Review submitted')
            ->send();
    }

    #[Computed]
    public function applicationReviewForm(): ?Form
    {
        return Form::key('applicationReview')->first();
    }

    #[Computed]
    public function owner(): User
    {
        return filled($this->user) ? $this->user : Auth::user();
    }

    public function mount(Application $application, ?User $user = null)
    {
        $this->authorize('vote', $application);

        $this->application = $application;
        $this->user = $user;

        $this->review = $application->reviews()
            ->wherePivot('user_id', $this->owner->id)
            ->first()->pivot;

        $this->form->setReview(
            application: $this->application,
            review: $this->review,
            user: $this->owner
        );

        $submission = FormSubmission::query()
            ->whereMorphRelation('owner', User::class, 'id', $this->owner->id)
            ->where('meta->application_id', $this->application->id)
            ->first();

        if (blank($submission)) {
            $this->values = collect($this->applicationReviewForm->published_fields ?? [])
                ->flatMap(fn ($item) => [data_get($item, 'data.attrs.id') => ''])
                ->all();
        } else {
            $this->values = $submission->responses
                ->flatMap(fn (FormSubmissionResponse $response) => [$response->field_uid => $response->value])
                ->all();
        }
    }

    public function render()
    {
        return view('pages.applications.livewire.review-modal', [
            'applicationReviewForm' => $this->applicationReviewForm,
        ]);
    }
}
