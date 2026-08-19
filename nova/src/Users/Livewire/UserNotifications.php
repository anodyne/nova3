<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Carbon\CarbonInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Users\Enums\NotificationStatus;
use Nova\Users\Models\User;
use Nova\Users\Resources\NotificationResource;

/**
 * @property-read int $allCount
 * @property-read array<string, mixed> $notifications
 * @property-read int $unreadCount
 * @property-read User $user
 */
class UserNotifications extends SlideOver
{
    public NotificationStatus $status = NotificationStatus::Unread;

    #[Computed]
    public function allCount(): int
    {
        return $this->user->notifications()->count();
    }

    public function clearAllNotifications(): void
    {
        $this->user->notifications()->delete();
    }

    public function clearNotification($notificationId): void
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

    public function markNotificationAsRead($notificationId): void
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

    #[Computed]
    public function notifications(): array
    {
        $base = $this->status === NotificationStatus::Unread
            ? $this->user->unreadNotifications()
            : $this->user->notifications();

        $paginator = $base->select(['id', 'data', 'type', 'read_at', 'created_at'])
            ->latest('created_at')
            ->simplePaginate(50);

        $now = now();
        $startToday = $now->copy()->startOfDay();
        $startYesterday = $now->copy()->subDay()->startOfDay();
        $startLast7 = $now->copy()->subDays(7)->startOfDay();

        $grouped = collect($paginator->items())
            ->groupBy(function (
                DatabaseNotification $notification,
            ) use ($startToday, $startYesterday, $startLast7): string {
                $timestamp = $notification->getAttribute('created_at');

                if (! $timestamp instanceof CarbonInterface) {
                    return 'older';
                }

                return match (true) {
                    $timestamp >= $startToday => 'today',
                    $timestamp >= $startYesterday && $timestamp < $startToday => 'yesterday',
                    $timestamp >= $startLast7 => 'last_7_days',
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
            ->filter(fn ($value): bool => $value && $value->isNotEmpty())
            ->map(fn ($value) => $toArray($value))
            ->all();
    }

    public function render(): Factory|View
    {
        return view('pages.users.livewire.notifications', [
            'allCount' => $this->allCount,
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
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
