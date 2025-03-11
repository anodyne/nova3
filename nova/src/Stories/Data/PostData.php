<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Nova\Stories\Enums\ContentRatingValue;

/**
 * @method static static from(?string $content, ?int $post_type_id, ?int $story_id, ?string $title, ?string $day, ?string $time, ?string $location, ContentRatingValue $rating_language, ContentRatingValue $rating_sex, ContentRatingValue $rating_violence)
 */
#[StripExtraParameters]
readonly class PostData extends Bag
{
    public function __construct(
        public ?string $content,
        public ?int $post_type_id,
        public ?int $story_id,
        public ?string $title,
        public ?string $day,
        public ?string $time,
        public ?string $location,
        public ContentRatingValue $rating_language,
        public ContentRatingValue $rating_sex,
        public ContentRatingValue $rating_violence
    ) {}
}
