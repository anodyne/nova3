<?php

declare(strict_types=1);

namespace Nova\Announcements\Listeners;

use Nova\Announcements\Events\AnnouncementPublished;
use Nova\Foundation\Notifications\Discord\DiscordAlert;
use Nova\Foundation\Notifications\Discord\DiscordEmbed;
use Nova\Foundation\Notifications\Discord\DiscordMessage;

class SendAnnouncementPublishedNotificationToDiscord
{
    public function handle(AnnouncementPublished $event): void
    {
        $announcement = $event->announcement;

        $message = (new DiscordMessage)
            ->content('A new announcement has been published!')
            ->embed(function (DiscordEmbed $embed) use ($announcement) {
                $embed->title($announcement->title, route('admin.announcements.show', $announcement));
            });

        DiscordAlert::make('announcement-published')->send($message);
    }
}
