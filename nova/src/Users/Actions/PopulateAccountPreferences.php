<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Users\Data\UserPreferences;
use Nova\Users\Enums\Appearance;
use Nova\Users\Models\User;

class PopulateAccountPreferences extends Action
{
    public function handle(User $user): User
    {
        $user->preferences = UserPreferences::from(
            appearance: Appearance::Light,
            timezone: 'UTC',
            languageContentRatingWarningThreshold: ContentRatingValue::Game,
            sexContentRatingWarningThreshold: ContentRatingValue::Game,
            violenceContentRatingWarningThreshold: ContentRatingValue::Game
        );
        $user->save();

        return $user->refresh();
    }
}
