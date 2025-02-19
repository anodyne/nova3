<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Bag;
use Nova\Stories\Enums\ContentRatingValue;

/**
 * @method static static from(ContentRatingValue $rating, ?string $description0, ?string $description1, ?string $description2, ?string $description3, ContentRatingValue $warningThreshold, ?string $warningThresholdMessage)
 */
readonly class ContentRating extends Bag
{
    public function __construct(
        public ContentRatingValue $rating,
        public ?string $description0,
        public ?string $description1,
        public ?string $description2,
        public ?string $description3,
        public ContentRatingValue $warningThreshold,
        public ?string $warningThresholdMessage,
    ) {}

    public function getDescription(): ?string
    {
        return $this->{"description{$this->rating->value}"};
    }
}
