<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Foundation\Models\NotificationType;
use Nova\Foundation\Models\UserNotificationPreference;
use Nova\Users\Models\User;

class NotificationSetting extends ModalComponent
{
    public NotificationType $notification;

    public ?User $user = null;

    public ?UserNotificationPreference $notifiable = null;

    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    public function mount(NotificationType $notification, $userId = null)
    {
        $this->notification = $notification;
        $this->user = $userId ? User::find($userId) : null;
        $this->setNotifiable();
    }

    public function render()
    {
        return view('pages.settings.livewire.notification-setting');
    }

    protected function setNotifiable(): void
    {
        $this->notifiable = $this->notification->getPreferenceForUser($this->user);
    }

    public function switchToGlobalSetting(): void
    {
        $this->user = null;

        $this->setNotifiable();
    }

    public function switchToPersonalSetting(): void
    {
        $this->user = auth()->user();

        $this->setNotifiable();
    }
}
