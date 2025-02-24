<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Users\Models\User;
use Nova\Users\Resources\NotificationResource;

class UserNotifications extends SlideOver
{
    public function clearAllNotifications(): void
    {
        $this->user->notifications()->delete();
    }

    #[Computed]
    public function notifications(): array
    {
        return NotificationResource::collection(
            $this->user->notifications
        )->toArray(request());
    }

    #[Computed]
    public function hasNotifications(): bool
    {
        return count($this->notifications) > 0;
    }

    public function markAllNotificationsAsRead(): void
    {
        $this->user->unreadNotifications->markAsRead();
    }

    public function clearNotification($notificationId)
    {
        $this->user
            ->notifications()
            ->where(['id' => $notificationId])
            ->delete();
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->user
            ->notifications()
            ->where(['id' => $notificationId])
            ->update(['read_at' => now()]);
    }

    #[Computed]
    public function user(): User
    {
        return Auth::user();
    }

    public function render()
    {
        return view('pages.users.livewire.notifications', [
            'hasNotifications' => $this->hasNotifications,
            'notifications' => $this->notifications,
        ]);
    }

    public static function size(): string
    {
        return 'xl';
    }
}
