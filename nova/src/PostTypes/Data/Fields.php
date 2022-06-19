<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class Fields extends Data implements Arrayable
{
    public function __construct(
        public Field $title,
        public Field $day,
        public Field $time,
        public Field $location,
        public Field $content,
        public Field $rating,
        public Field $summary,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            title: Field::from(data_get($array, 'title', [])),
            day: Field::from(data_get($array, 'day', [])),
            time: Field::from(data_get($array, 'time', [])),
            location: Field::from(data_get($array, 'location', [])),
            content: Field::from(data_get($array, 'content', [])),
            rating: Field::from(data_get($array, 'rating', [])),
            summary: Field::from(data_get($array, 'summary', [])),
        );
    }

    public function enabledFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var) => $var instanceof Field)
            ->filter(fn (Field $field) => $field->enabled)
            ->filter(fn (Field $field, $key) => $key !== 'rating');
    }

    public function requiredFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var) => $var instanceof Field)
            ->filter(fn (Field $field) => $field->required)
            ->filter(fn (Field $field, $key) => $key !== 'rating');
    }
}
