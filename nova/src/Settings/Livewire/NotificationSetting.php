<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Foundation\Models\Notifiable;
use Nova\Foundation\Models\SystemNotification;
use Nova\Users\Models\User;

class NotificationSetting extends ModalComponent
{
    public SystemNotification $notification;

    public ?User $user = null;

    public ?Notifiable $notifiable = null;

    public function mount(SystemNotification $notification, $userId)
    {
        $this->notification = $notification;
        $this->user = $userId ? User::find($userId) : null;
        $this->setNotifiable();
    }

    public function render()
    {
        return view('livewire.settings.notification-setting');
    }

    protected function setNotifiable(): void
    {
        if ($this->user === null) {
            $this->notifiable = $this->notification->notifiables()->whereNull('user_id')->first();
        } else {
            $this->notifiable = $this->notification->notifiables()->where('user_id', $this->user->id)->first();
        }
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
