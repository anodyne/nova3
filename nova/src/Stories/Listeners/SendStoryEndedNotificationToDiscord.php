<?php

declare(strict_types=1);

namespace Nova\Stories\Listeners;

use Nova\Foundation\Models\NotificationType;
use Nova\Foundation\Notifications\Discord\DiscordAlert;
use Nova\Foundation\Notifications\Discord\DiscordEmbed;
use Nova\Foundation\Notifications\Discord\DiscordMessage;
use Nova\Stories\Events\StoryEnded;

class SendStoryEndedNotificationToDiscord
{
    public function handle(StoryEnded $event): void
    {
        $story = $event->story;

        $notificationType = NotificationType::where('key', 'story-ended')->first();

        $message = (new DiscordMessage)
            ->content('A story has been ended')
            ->embed(function (DiscordEmbed $embed) use ($story, $notificationType) {
                $embed->title($story->title, route('admin.stories.show', $story))
                    ->description($story->description)
                    ->color($notificationType->discord_color);
            });

        DiscordAlert::make()->for($notificationType)->send($message);
    }
}
