<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications\Discord;

use Closure;

class DiscordMessage
{
    /**
     * The message contents (up to 2000 characters).
     *
     * @var string
     */
    public $content;

    /**
     * Override the default username of the webhook.
     *
     * @var string|null
     */
    public $username;

    /**
     * Override the default avatar of the webhook.
     *
     * @var string|null
     */
    public $avatar_url;

    /**
     * true if this is a TTS message.
     *
     * @var string|null
     */
    public $tts;

    /**
     * Embedded rich content.
     *
     * @var array
     */
    public $embeds;

    /**
     * Http options
     *
     * @var array
     */
    public $http = [];

    /**
     * Set the content of the message.
     *
     * @param  string  $content
     */
    public function content($content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Override the default username and avatar url of the webhook.
     *
     * @param  string  $username
     * @param  string|null  $avatar_url
     */
    public function from($username, $avatar_url = null): static
    {
        $this->username = $username;

        if (! is_null($avatar_url)) {
            $this->avatar_url = $avatar_url;
        }

        return $this;
    }

    /**
     * Send as a TTS message.
     *
     * @param  bool|null  $enabled
     */
    public function tts($enabled = true): static
    {
        $this->tts = $enabled ? 'true' : 'false';

        return $this;
    }

    /**
     * Define an embedded rich content for the message.
     */
    public function embed(Closure $callback): static
    {
        $this->embeds[] = $discordEmbed = new DiscordEmbed;

        $callback($discordEmbed);

        return $this;
    }

    /**
     * Set additional request options for the Guzzle HTTP client.
     */
    public function http(array $options): static
    {
        $this->http = $options;

        return $this;
    }
}
