<?php

declare(strict_types=1);

namespace Nova\Stories\Listeners;

use Nova\Foundation\Notifications\Discord\DiscordAlert;
use Nova\Foundation\Notifications\Discord\DiscordEmbed;
use Nova\Foundation\Notifications\Discord\DiscordMessage;
use Nova\Stories\Events\PostPublished;

class SendPostPublishedNotificationToDiscord
{
    public function handle(PostPublished $event): void
    {
        $post = $event->post;

        $message = (new DiscordMessage)
            ->content('A new '.str($post->postType->name)->lower().' has been published!')
            ->embed(function (DiscordEmbed $embed) use ($post) {
                $embed->title($post->title, route('posts.show', [$post->story, $post]))
                    ->description($post->authors_string)
                    ->color($post->postType->color)
                    ->when(filled($post->location), fn ($embed) => $embed->field('Location', $post->location))
                    ->when(filled($post->time) || filled($post->day), fn ($embed) => $embed->field('Timeline', $post->timeline))
                    ->footer('Published in '.$post->story->title);
            });

        DiscordAlert::make('post-published')->send($message);
    }
}
