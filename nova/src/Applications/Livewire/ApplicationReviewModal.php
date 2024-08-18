<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use LivewireUI\Modal\ModalComponent;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReview;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Actions\SyncFormSubmissionResponses;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormSubmission;
use Nova\Forms\Models\FormSubmissionResponse;
use Nova\Users\Models\User;

class ApplicationReviewModal extends ModalComponent
{
    public Application $application;

    public ?User $user = null;

    public ?ApplicationReview $review;

    public ApplicationReviewForm $form;

    public array $values = [];

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function save(): void
    {
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

        $this->dismiss();
    }

    #[Computed]
    public function applicationReviewForm(): ?Form
    {
        return Form::key('applicationReview')->first();
    }

    #[Computed]
    public function owner(): User
    {
        return $this->user ?? Auth::user();
    }

    public function mount()
    {
        $this->review = $this->application->reviews()
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
            $this->values = collect($this->applicationReviewForm->published_fields['content'] ?? [])
                ->flatMap(fn ($item) => [data_get($item, 'attrs.values.uid') => ''])
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
