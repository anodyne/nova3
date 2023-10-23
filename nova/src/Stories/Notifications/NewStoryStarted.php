<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Awssat\Notifications\Messages\DiscordMessage;
use Nova\Foundation\Notifications\PreferenceBasedNotification;

class NewStoryStarted extends PreferenceBasedNotification
{
    protected string $key = 'new-story-started';

    public function toDiscord($notifiable)
    {
        return (new DiscordMessage())
            ->from('Nova NextGen')
            ->content('A new story has been started!')
            ->embed(function ($embed) {
                return $embed->title('Encounter at Farpoint')
                    ->color('406ceb')
                    ->description("Captain Jean-Luc Picard leads the crew of the USS Enterprise-D on its maiden voyage, to examine a new planetary station for trade with the Federation. On the way, they encounter Q, an omnipotent extra-dimensional being, who challenges Humanity as a barbaric, inferior species. Picard and his new crew must hold off Q's challenge and solve the puzzle of Farpoint station on Deneb IV, a base that is far more than it seems to be.");
                // ->field('Nova Version', '3.0-alpha.0')
                // ->field('PHP', '7.4')
                // ->footer('This is a footer...')
            });
    }
}
