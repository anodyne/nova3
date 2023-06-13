<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Resources\NotificationResource;

class UserNotifications extends Component
{
    public function clearAllNotifications(): void
    {
        auth()->user()->notifications()->delete();
    }

    public function getNotificationsProperty(): array
    {
        return NotificationResource::collection(
            auth()->user()->notifications
        )->toArray(request());
    }

    public function getHasNotificationsProperty(): bool
    {
        return auth()->user()->notifications()->count() > 0;
    }

    public function getHasUnreadNotificationsProperty(): bool
    {
        return auth()->user()->unreadNotifications()->count() > 0;
    }

    public function getUnreadNotificationsCountProperty(): int
    {
        return auth()->user()->unreadNotifications()->count();
    }

    public function markAllNotificationsAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function clearNotification($notificationId)
    {
        auth()->user()
            ->notifications()
            ->where(['id' => $notificationId])
            ->delete();
    }

    public function markNotificationAsRead($notificationId)
    {
        auth()->user()
            ->notifications()
            ->where(['id' => $notificationId])
            ->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.users.notifications', [
            'hasNotifications' => $this->hasNotifications,
            'hasUnreadNotifications' => $this->hasUnreadNotifications,
            'notifications' => $this->notifications,
            'unreadNotificationsCount' => $this->unreadNotificationsCount,
        ]);
    }
}
