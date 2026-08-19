<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications\Discord;

use Illuminate\Support\Traits\Conditionable;

class DiscordEmbed
{
    use Conditionable;

    /**
     * The title of embed.
     *
     * @var string
     */
    public $title;

    /**
     * The description of embed.
     *
     * @var string
     */
    public $description;

    /**
     * The URL of embed.
     *
     * @var string
     */
    public $url;

    /**
     * The color code of the embed.
     *
     * @var int
     */
    public $color;

    /**
     * The footer information.
     *
     * @var array
     */
    public $footer;

    /**
     * The image information.
     *
     * @var array
     */
    public $image;

    /**
     * The thumbnail information.
     *
     * @var array
     */
    public $thumbnail;

    /**
     * The author information.
     *
     * @var array
     */
    public $author;

    /**
     * The fields information.
     *
     * @var array
     */
    public $fields;

    /**
     * Set the title (url) of embed.
     *
     * @param  string  $title
     * @param  string|null  $url
     */
    public function title($title, $url = ''): static
    {
        $this->title = $title;
        $this->url = $url;

        return $this;
    }

    /**
     * Set the description (text) of embed.
     *
     * @param  string  $description
     */
    public function description($description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the color code of the embed.
     *
     * @param  string  $code
     */
    public function color($code): static
    {
        $this->color = hexdec($code);

        return $this;
    }

    /**
     * Set the footer information.
     *
     * @param  string  $text
     * @param  string|null  $icon_url
     */
    public function footer($text, $icon_url = ''): static
    {
        $this->footer = [
            'text' => $text,
            'icon_url' => $icon_url,
        ];

        return $this;
    }

    /**
     * Set the image (url) information.
     *
     * @param  string  $url
     */
    public function image($url): static
    {
        $this->image = [
            'url' => $url,
        ];

        return $this;
    }

    /**
     * Set the thumbnail (url) information.
     *
     * @param  string  $url
     */
    public function thumbnail($url): static
    {
        $this->thumbnail = [
            'url' => $url,
        ];

        return $this;
    }

    /**
     * Set the author information.
     *
     * @param  string  $name
     * @param  string|null  $url
     * @param  string|null  $icon_url
     */
    public function author($name, $url = '', $icon_url = ''): static
    {
        $this->author = [
            'name' => $name,
            'url' => $url,
            'icon_url' => $icon_url,
        ];

        return $this;
    }

    public function field($title, $content = ''): static
    {
        if (is_callable($title)) {
            $callback = $title;

            $callback($discordEmbedField = new DiscordEmbedField);

            $this->fields[] = $discordEmbedField;

            return $this;
        }

        $this->fields[$title] = $content;

        return $this;
    }

    /**
     * Set the fields of the attachment.
     */
    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }
}
