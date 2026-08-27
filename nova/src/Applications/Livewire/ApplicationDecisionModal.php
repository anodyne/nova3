<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\Modal;

class ApplicationDecisionModal extends Modal
{
    #[Locked]
    public string|Application $application;

    public ApplicationDecisionForm $form;

    public function save(): void
    {
        $this->authorize('decide', $this->application);

        $this->form->save();

        $notification = match ($this->form->result) {
            ApplicationResult::Accept => Notification::make()->success()->title('Application accepted'),
            ApplicationResult::Deny => Notification::make()->success()->title('Application denied'),
            ApplicationResult::Pending => Notification::make()->warning()->title('Something went wrong'),
            default => null,
        };

        $notification
            ->body('The applicant has been notified of the decision.')
            ->send();

        $this->close();
    }

    public function mount(Application $application): void
    {
        $this->authorize('decide', $application);

        $this->application = $application;

        $this->form->setApplication($this->application);
    }

    public function render(): \Illuminate\Contracts\View\View|Factory|View
    {
        return view('pages.applications.livewire.decision-modal');
    }
}
