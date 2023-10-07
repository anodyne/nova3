<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Users\Resources\NotificationResource;

class UserNotifications extends Component
{
    public function clearAllNotifications(): void
    {
        auth()->user()->notifications()->delete();
    }

    #[Computed]
    public function notifications(): array
    {
        return NotificationResource::collection(
            auth()->user()->notifications
        )->toArray(request());
    }

    #[Computed]
    public function hasNotifications(): bool
    {
        return count($this->notifications) > 0;
    }

    #[Computed]
    public function unreadNotificationsCount(): int
    {
        return once(fn () => auth()->user()->unreadNotifications)->count();
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
        return view('pages.users.livewire.notifications', [
            'hasNotifications' => $this->hasNotifications,
            'notifications' => $this->notifications,
            'unreadNotificationsCount' => $this->unreadNotificationsCount,
        ]);
    }
}
