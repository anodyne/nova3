<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Enums\NotificationChannel;
use Nova\Foundation\Models\NotificationType;
use Nova\Users\Models\User;

abstract class PreferenceBasedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $key;

    protected ?NotificationType $notificationType = null;

    /**
     * @return array<string, mixed>
     */
    abstract public function toArray(object $notifiable): array;

    abstract public function mailable(): Mailable;

    /**
     * @param  User  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $this->getNotificationType();

        return match ($this->notificationType->audience) {
            NotificationAudience::Admin => $this->setAdminAudienceChannels(),
            default => $this->setNonAdminAudienceChannels($notifiable),
        };
    }

    /** @param User $notifiable */
    public function toMail(object $notifiable): Mailable
    {
        return $this->mailable()->to($notifiable->email);
    }

    protected function getNotificationType(): NotificationType
    {
        $this->notificationType = NotificationType::where('key', $this->key)->first();

        return $this->notificationType;
    }

    /** @return array<int, string> */
    protected function setAdminAudienceChannels(): array
    {
        $channels = [];

        foreach (NotificationChannel::cases() as $channel) {
            if ($this->notificationType->{$channel->value}) {
                $channels[] = $channel->value;
            }
        }

        return $channels;
    }

    /**
     * @param  User  $notifiable
     * @return array<int, string>
     */
    protected function setNonAdminAudienceChannels(object $notifiable): array
    {
        $channels = [];

        $userNotificationPreference = $this->notificationType->preferenceForUser($notifiable);

        foreach (NotificationChannel::cases() as $channel) {
            if ($this->notificationType->{$channel->value} && $userNotificationPreference->{$channel->value}) {
                $channels[] = $channel->value;
            }
        }

        return $channels;
    }
}
