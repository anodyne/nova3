<?php

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Resources\NotificationResource;

class UserNotifications extends Component
{
    public $notifications = [];

    public function clearAllNotifications(): void
    {
        $this->getNotificationsAsBuilder()->delete();

        $this->refreshNotifications();
    }

    public function getNotifications()
    {
        return auth()->user()->notifications;
    }

    public function getNotificationsAsBuilder()
    {
        return auth()->user()->notifications();
    }

    public function getUnreadNotifications()
    {
        return auth()->user()->unreadNotifications;
    }

    public function hasNotifications(): bool
    {
        return $this->getNotifications()->count() > 0;
    }

    public function hasUnreadNotifications(): bool
    {
        return $this->getUnreadNotifications()->count() > 0;
    }

    public function markAllNotificationsAsRead(): void
    {
        $this->getUnreadNotifications()->markAsRead();

        $this->refreshNotifications();
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->getNotificationsAsBuilder()
            ->where(['id' => $notificationId])
            ->update(['read_at' => now()]);

        $this->refreshNotifications();
    }

    public function refreshNotifications(): void
    {
        $this->notifications = NotificationResource::collection(
            $this->getNotifications()
        )->toArray(request());
    }

    public function mount()
    {
        $this->refreshNotifications();
    }

    public function render()
    {
        return view('livewire.users.notifications');
    }
}
