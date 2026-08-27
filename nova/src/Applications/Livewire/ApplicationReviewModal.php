<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use LogicException;
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

/**
 * @property-read ?Form $applicationReviewForm
 * @property-read User $owner
 */
class ApplicationReviewModal extends Modal
{
    #[Locked]
    public string|Application $application;

    public ApplicationReviewForm $form;

    #[Locked]
    public ?ApplicationReview $review = null;

    #[Locked]
    public string|User|null $user = null;

    /** @var array<string, mixed> */
    public array $values = [];

    #[Computed]
    public function applicationReviewForm(): ?Form
    {
        return Form::key('applicationReview')->first();
    }

    public function mount(Application $application, ?User $user = null): void
    {
        $this->authorize('vote', $application);

        $this->application = $application;
        $this->user = $user;

        $this->review = ApplicationReview::query()
            ->where('application_id', $application->id)
            ->where('user_id', $this->owner->id)
            ->firstOrFail();

        $this->form->setReview(
            application: $application,
            review: $this->review,
            user: $this->owner
        );

        $submission = FormSubmission::query()
            ->whereMorphRelation('owner', User::class, 'id', $this->owner->id)
            ->where('meta->application_id', $application->id)
            ->first();

        if (blank($submission)) {
            $this->values = collect($this->applicationReviewForm->published_fields ?? [])
                ->flatMap(fn ($item): array => [data_get($item, 'data.attrs.id') => ''])
                ->all();
        } else {
            $this->values = $submission->responses
                ->flatMap(fn (FormSubmissionResponse $response): array => [$response->field_uid => $response->value])
                ->all();
        }
    }

    #[Computed]
    public function owner(): User
    {
        return $this->user instanceof User
            ? $this->user
            : Auth::user() ?? throw new LogicException('An authenticated user is required.');
    }

    public function render(): Factory|View
    {
        return view('pages.applications.livewire.review-modal', [
            'applicationReviewForm' => $this->applicationReviewForm,
        ]);
    }

    public function save(): void
    {
        $application = $this->getApplicationModel();

        $this->authorize('vote', $application);

        $this->form->save();

        if (filled($this->applicationReviewForm->published_fields)) {
            $submission = CreateFormSubmission::run(
                form: $this->applicationReviewForm,
                owner: $this->owner,
                meta: ['application_id' => $application->id]
            );

            SyncFormSubmissionResponses::run($submission, $this->values);
        }

        $this->dispatch('review-submitted');

        $this->close();

        Notification::make()->success()
            ->title('Review submitted')
            ->send();
    }

    protected function getApplicationModel(): Application
    {
        return $this->application instanceof Application
            ? $this->application
            : throw new LogicException('The application has not been initialized.');
    }
}
