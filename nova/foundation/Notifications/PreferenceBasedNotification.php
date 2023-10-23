<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Foundation\Enums\NotificationChannel;
use Nova\Foundation\Models\NotificationType;

abstract class PreferenceBasedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $key;

    public function via(object $notifiable): array
    {
        $channels = [];

        $preference = $this->getPreference($notifiable);

        foreach (NotificationChannel::cases() as $channel) {
            if ($preference->{$channel}) {
                $channels[] = $channel;
            }
        }

        return $channels;
    }

    abstract public function toArray(object $notifiable): array;

    abstract public function toMail(object $notifiable): Mailable;

    // abstract public function toDiscord(object $notifiable);

    protected function getPreference(object $notifiable)
    {
        $notification = NotificationType::where('key', $this->key)->first();

        return $notification->preferencesForUser($notifiable);
    }
}
