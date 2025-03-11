<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Bag;

/**
 * @method static static from(?ContentRating $language, ?ContentRating $sex, ?ContentRating $violence)
 */
readonly class ContentRatings extends Bag
{
    public function __construct(
        public ?ContentRating $language,
        public ?ContentRating $sex,
        public ?ContentRating $violence,
    ) {}
}
