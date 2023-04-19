<?php

declare(strict_types=1);

namespace Nova\Stories\Notifications;

use Awssat\Notifications\Messages\DiscordMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class StoryPostPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['discord'];
    }

    public function toDiscord($notifiable)
    {
        return (new DiscordMessage())
            ->from('Nova NextGen')
            ->content('A new story post has been published!')
            ->embed(function ($embed) {
                return $embed->title('Frontier Medicine', 'https://google.com')
                    ->color('9F7AEA')
                    // ->description("Captain Jean-Luc Picard leads the crew of the USS Enterprise-D on its maiden voyage, to examine a new planetary station for trade with the Federation. On the way, they encounter Q, an omnipotent extra-dimensional being, who challenges Humanity as a barbaric, inferior species. Picard and his new crew must hold off Q's challenge and solve the puzzle of Farpoint station on Deneb IV, a base that is far more than it seems to be.")
                    ->field('Story', 'Season 1 - Into the Deep')
                    ->field('Location', 'Federation Medical Corps Aid Station - Yuil XI')
                    ->field('Timeline', '6 months previous')
                    ->field('Authors', 'Lieutenant Commander Alwyn Llwyd, Captain Edward Drake, & Lieutenant Colonel Aaron Drake');
                    // ->field('Post URL', "https://heresyourlink.com/story/into-the-deep/post/1")
                    // ->footer('This is a footer...')
            });
    }
}
