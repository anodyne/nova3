<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @method static static from(Field $title, Field $day, Field $time, Field $location, Field $content, Field $rating, Field $summary)
 */
readonly class Fields extends Bag
{
    public function __construct(
        public Field $title,
        public Field $day,
        public Field $time,
        public Field $location,
        public Field $content,
        public Field $rating,
        public Field $summary,
    ) {}

    public function enabledFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var) => $var instanceof Field)
            ->filter(fn (Field $field) => $field->enabled);
    }

    public function requiredFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var) => $var instanceof Field)
            ->filter(fn (Field $field) => $field->required)
            ->filter(fn (Field $field, $key) => $key !== 'rating');
    }

    public function showMetaFields(): bool
    {
        return $this->location->enabled || $this->day->enabled || $this->time->enabled;
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'title' => Field::from($request),
            'day' => Field::from($request),
            'time' => Field::from($request),
            'location' => Field::from($request),
            'content' => Field::from($request),
            'rating' => Field::from($request),
            'summary' => Field::from($request),
        ];
    }
}
