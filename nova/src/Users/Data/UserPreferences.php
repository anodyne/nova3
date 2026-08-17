<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Bag;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Users\Enums\Appearance;

/**
 * @method static static from(Appearance $appearance, ?string $timezone, ?int $languageContentRatingWarningThreshold, ?int $sexContentRatingWarningThreshold, ?int $violenceContentRatingWarningThreshold)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class UserPreferences extends Bag
{
    public function __construct(
        public Appearance $appearance,
        public ?string $timezone,
        public ContentRatingValue $languageContentRatingWarningThreshold,
        public ContentRatingValue $sexContentRatingWarningThreshold,
        public ContentRatingValue $violenceContentRatingWarningThreshold,
    ) {}

    public function hasContentRatingPreferences(): bool
    {
        $truthyValues = [
            ContentRatingValue::Level0,
            ContentRatingValue::Level1,
            ContentRatingValue::Level2,
            ContentRatingValue::Level3,
        ];

        return match (true) {
            in_array($this->languageContentRatingWarningThreshold, $truthyValues) => true,
            in_array($this->sexContentRatingWarningThreshold, $truthyValues) => true,
            in_array($this->violenceContentRatingWarningThreshold, $truthyValues) => true,
            default => false,
        };
    }
}
