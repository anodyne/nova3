<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications\Discord;

use Illuminate\Support\Facades\Http;
use Nova\Foundation\Models\NotificationType;

class DiscordAlert
{
    protected ?NotificationType $notificationType;

    public function __construct(?string $notificationKey = null)
    {
        if (filled($notificationKey)) {
            $this->notificationType = NotificationType::where('key', $notificationKey)->first();
        }
    }

    public function for(NotificationType $notificationType): self
    {
        $this->notificationType = $notificationType;

        return $this;
    }

    public function send(DiscordMessage $message): void
    {
        if ($this->notificationType->discord && filled($this->notificationType->discord_webhook)) {
            Http::post($this->notificationType->discord_webhook, $this->buildJsonPayload($message));
        }
    }

    protected function buildJsonPayload(DiscordMessage $message)
    {
        $optionalFields = array_filter([
            'username' => data_get($message, 'username'),
            'avatar_url' => data_get($message, 'avatar_url'),
            'tts' => data_get($message, 'tts'),
            'timestamp' => data_get($message, 'timestamp'),
        ]);

        return array_merge([
            'content' => $message->content,
            'embeds' => $this->embeds($message),
        ], $optionalFields);
    }

    protected function embeds(DiscordMessage $message)
    {
        return collect($message->embeds)->map(function (DiscordEmbed $embed) {
            return array_filter([
                'color' => $embed->color,
                'title' => $embed->title,
                'description' => $embed->description,
                'url' => $embed->url,
                'thumbnail' => $embed->thumbnail,
                'image' => $embed->image,
                'footer' => $embed->footer,
                'author' => $embed->author,
                'fields' => $this->embedFields($embed),
            ]);
        })->all();
    }

    protected function embedFields(DiscordEmbed $embed)
    {
        return collect($embed->fields)->map(function ($value, $key) {
            if ($value instanceof DiscordEmbedField) {
                return $value->toArray();
            }

            return ['name' => $key, 'value' => $value, 'inline' => true];
        })->values()->all();
    }

    public static function make(?string $notificationKey = null): static
    {
        return app(static::class, ['notificationKey' => $notificationKey]);
    }
}
