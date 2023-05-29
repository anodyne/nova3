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
