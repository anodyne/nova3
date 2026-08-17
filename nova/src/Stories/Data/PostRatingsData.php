<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Nova\Stories\Enums\ContentRatingValue;

/**
 * @method static static from(ContentRatingValue $rating_language, ContentRatingValue $rating_sex, ContentRatingValue $rating_violence)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class PostRatingsData extends Bag
{
    public function __construct(
        public ContentRatingValue $rating_language,
        public ContentRatingValue $rating_sex,
        public ContentRatingValue $rating_violence
    ) {}
}
