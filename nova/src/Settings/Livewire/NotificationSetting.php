<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use LivewireUI\Modal\ModalComponent;
use Nova\Foundation\Models\SystemNotification;

class NotificationSetting extends ModalComponent
{
    public SystemNotification $notification;

    public function mount()
    {
        $this->notification = SystemNotification::find(4);
    }

    public function render()
    {
        return view('livewire.settings.notification-setting');
    }
}
