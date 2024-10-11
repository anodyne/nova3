<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Livewire\Attributes\Locked;
use LivewireUI\Modal\ModalComponent;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Foundation\Filament\Notifications\Notification;

class ApplicationDecisionModal extends ModalComponent
{
    #[Locked]
    public Application $application;

    public ApplicationDecisionForm $form;

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function save(): void
    {
        $this->authorize('decide', $this->application);

        $this->form->save();

        $notification = match ($this->form->result) {
            ApplicationResult::Accept => Notification::make()->success()->title('Application accepted'),
            ApplicationResult::Deny => Notification::make()->success()->title('Application denied'),
        };

        $notification
            ->body('The applicant has been notified of the decision.')
            ->send();

        $this->dismiss();
    }

    public function mount()
    {
        $this->authorize('decide', $this->application);

        $this->form->setApplication($this->application);
    }

    public function render()
    {
        return view('pages.applications.livewire.decision-modal');
    }
}
