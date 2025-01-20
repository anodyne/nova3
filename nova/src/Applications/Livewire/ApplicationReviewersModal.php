<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use LivewireUI\Modal\ModalComponent;
use Nova\Applications\Models\Application;
use Nova\Applications\Notifications\ApplicationReadyForReview;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Models\User;

class ApplicationReviewersModal extends ModalComponent
{
    #[Locked]
    public Application $application;

    public array $selectedReviewers = [];

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function save(): void
    {
        $this->authorize('decide', $this->application);

        $changes = $this->application->reviews()->sync($this->selectedReviewers);

        if (count($changes['attached']) > 0) {
            $attachedUsers = User::query()
                ->whereIn('id', $changes['attached'])
                ->get();

            $attachedUsers->each->notify(new ApplicationReadyForReview($this->application));

            activity()
                ->performedOn($this->application)
                ->withProperty('addedReviewers', $attachedUsers->pluck('id'))
                ->event('reviewers-added')
                ->log('reviewers-added');
        }

        if (count($changes['detached']) > 0) {
            $detachedUsers = User::query()
                ->whereIn('id', $changes['detached'])
                ->get();

            activity()
                ->performedOn($this->application)
                ->withProperty('removedReviewers', $detachedUsers->pluck('id'))
                ->event('reviewers-removed')
                ->log('reviewers-removed');
        }

        $this->dispatch('reviewers-updated');

        $this->dismiss();

        if (count($changes['attached']) > 0 || count($changes['detached']) > 0) {
            Notification::make()->success()
                ->title('Application reviewers updated')
                ->send();
        }
    }

    #[Computed]
    public function users(): Collection
    {
        return User::query()->active()->get();
    }

    public function mount()
    {
        $this->authorize('decide', $this->application);

        $this->selectedReviewers = $this->application->reviews
            ->flatMap(fn (User $user) => [(string) $user->id])
            ->all();
    }

    public function render()
    {
        return view('pages.applications.livewire.reviewers-modal', [
            'users' => $this->users,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }
}
