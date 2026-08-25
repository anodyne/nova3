<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @method static static from(Field $title, Field $day, Field $time, Field $location, Field $content, Field $rating, Field $summary)
 *
 * @phpstan-method static static from(mixed ...$values)
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

    /** @return Collection<string, Field> */
    public function enabledFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var): bool => $var instanceof Field)
            ->filter(fn (Field $field): bool => $field->enabled);
    }

    /** @return Collection<string, Field> */
    public function requiredFields(): Collection
    {
        return collect(get_object_vars($this))
            ->filter(fn ($var): bool => $var instanceof Field)
            ->filter(fn (Field $field): bool => $field->required)
            ->filter(fn (Field $field, $key): bool => $key !== 'rating');
    }

    public function showMetaFields(): bool
    {
        return $this->location->enabled || $this->day->enabled || $this->time->enabled;
    }

    /** @return array{title: Field, day: Field, time: Field, location: Field, content: Field, rating: Field, summary: Field} */
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
