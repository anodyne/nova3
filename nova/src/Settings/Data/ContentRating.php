<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class ContentRating extends Data implements Arrayable
{
    public function __construct(
        public int $rating,
        public ?string $description_0,
        public ?string $description_1,
        public ?string $description_2,
        public ?string $description_3,
        public ?int $warning_threshold,
        public ?string $warning_threshold_message,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            rating: filter_var(data_get($data, 'rating', 1), FILTER_VALIDATE_INT),
            description_0: data_get($data, 'description_0', ''),
            description_1: data_get($data, 'description_1', ''),
            description_2: data_get($data, 'description_2', ''),
            description_3: data_get($data, 'description_3', ''),
            warning_threshold: filter_var(data_get($data, 'warning_threshold'), FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE),
            warning_threshold_message: data_get($data, 'warning_threshold_message', ''),
        );
    }

    public function getDescription(): ?string
    {
        return $this->{"description_{$this->rating}"};
    }
}
