<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

trait HasContentRatings
{
    public function showContentWarningForAdminSite(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                $languageThreshold = $this->contentRatingThreshold('language', forUser: true);
                $sexThreshold = $this->contentRatingThreshold('sex', forUser: true);
                $violenceThreshold = $this->contentRatingThreshold('violence', forUser: true);

                return match (true) {
                    is_numeric($languageThreshold) && $this->rating_language->value >= $languageThreshold => true,
                    is_numeric($sexThreshold) && $this->rating_sex->value >= $sexThreshold => true,
                    is_numeric($violenceThreshold) && $this->rating_violence->value >= $violenceThreshold => true,
                    default => false,
                };
            }
        );
    }

    public function showContentWarningForPublicSite(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                $languageThreshold = $this->contentRatingThreshold('language', forUser: false);
                $sexThreshold = $this->contentRatingThreshold('sex', forUser: false);
                $violenceThreshold = $this->contentRatingThreshold('violence', forUser: false);

                return match (true) {
                    filled($languageThreshold) && $this->rating_language >= $languageThreshold => true,
                    filled($sexThreshold) && $this->rating_sex >= $sexThreshold => true,
                    filled($violenceThreshold) && $this->rating_violence >= $violenceThreshold => true,
                    default => false,
                };
            }
        );
    }

    public function contentRatingThreshold(string $category, bool $forUser = false): ?string
    {
        $globalThreshold = settings("ratings.{$category}.warningThreshold");

        if (! $forUser) {
            return $globalThreshold->value;
        }

        /** @var User */
        $user = Auth::user();

        $preferences = $user?->preferences;

        if (! $preferences?->hasContentRatingPreferences()) {
            return $globalThreshold->value;
        }

        $property = "{$category}ContentRatingWarningThreshold";

        return $preferences?->{$property}->value;
    }
}
