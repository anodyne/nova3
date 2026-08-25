<?php

declare(strict_types=1);

namespace Nova\Foundation\Notifications\Discord;

class DiscordEmbedField
{
    /**
     * The name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * The value of the field.
     *
     * @var string
     */
    public $value;

    /**
     * Whether or not this field should display inline.
     *
     * @var bool
     */
    public $inline;

    /**
     * Set the name of the field.
     *
     * @param  string  $name
     */
    public function name($name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of the field.
     *
     * @param  string  $value
     */
    public function value($value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the name of the field.
     *
     * @param  bool|null  $inline
     */
    public function inline($inline = true): static
    {
        $this->inline = boolval($inline);

        return $this;
    }

    /**
     * Get an array representation of the embedded field.
     *
     * @return array{name: string, value: string, inline: bool}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'inline' => $this->inline,
        ];
    }
}
