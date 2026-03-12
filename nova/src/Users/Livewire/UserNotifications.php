<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Users\Enums\NotificationStatus;
use Nova\Users\Models\User;
use Nova\Users\Resources\NotificationResource;

class UserNotifications extends SlideOver
{
    public NotificationStatus $status = NotificationStatus::Unread;

    public function clearAllNotifications(): void
    {
        $this->user->notifications()->delete();
    }

    public function clearNotification($notificationId)
    {
        $this->user
            ->notifications()
            ->where(['id' => $notificationId])
            ->delete();
    }

    public function markAllNotificationsAsRead(): void
    {
        $this->user->unreadNotifications->markAsRead();
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->user
            ->notifications()
            ->where(['id' => $notificationId])
            ->update(['read_at' => now()]);
    }

    public function navigate($notificationId, $href): void
    {
        $this->markNotificationAsRead($notificationId);

        $this->redirect($href, true);
    }

    public function render()
    {
        return view('pages.users.livewire.notifications', [
            'allCount' => $this->allCount,
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }

    #[Computed]
    public function allCount(): int
    {
        return $this->user->notifications()->count();
    }

    #[Computed]
    public function notifications(): array
    {
        $base = $this->status === NotificationStatus::Unread
            ? $this->user->unreadNotifications()
            : $this->user->notifications();

        $items = $base->select(['id', 'data', 'type', 'read_at', 'created_at'])
            ->latest('created_at')
            ->simplePaginate(50);

        $now = now();
        $startToday = $now->copy()->startOfDay();
        $startYesterday = $now->copy()->subDay()->startOfDay();
        $startLast7 = $now->copy()->subDays(7)->startOfDay();

        $grouped = collect($items->items() ?? $items)
            ->groupBy(function ($n) use ($startToday, $startYesterday, $startLast7) {
                $ts = $n->created_at;

                return match (true) {
                    $ts >= $startToday => 'today',
                    $ts >= $startYesterday && $ts < $startToday => 'yesterday',
                    $ts >= $startLast7 => 'last_7_days',
                    default => 'older',
                };
            });

        $toArray = fn (Collection $c) => NotificationResource::collection($c)->toArray(request());

        return collect([
            'today' => $grouped->get('today'),
            'yesterday' => $grouped->get('yesterday'),
            'last_7_days' => $grouped->get('last_7_days'),
            'older' => $grouped->get('older'),
        ])
            ->filter(fn ($value) => $value && $value->isNotEmpty())
            ->map(fn ($value) => $toArray($value))
            ->all();
    }

    #[Computed]
    public function unreadCount(): int
    {
        return $this->user->unreadNotifications()->count();
    }

    #[Computed]
    public function user(): User
    {
        return Auth::user();
    }

    public static function size(): string
    {
        return 'xl';
    }
}
