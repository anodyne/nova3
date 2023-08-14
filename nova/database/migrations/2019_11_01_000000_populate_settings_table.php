<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRating;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Models\Settings;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => new General(),
            'email' => new Email(),
            'appearance' => new Appearance(
                theme: 'Pulsar',
                iconSet: 'tabler',
                avatarShape: 'squircle',
                imagePath: null,
                colorsGray: 'Gray',
                colorsPrimary: 'Sky',
                colorsDanger: 'Rose',
                colorsWarning: 'Amber',
                colorsSuccess: 'Emerald',
                colorsInfo: 'Purple',
                fontProvider: 'local',
                fontFamily: 'Inter'
            ),
            'meta_tags' => new MetaTags(),
            'characters' => new Characters(
                approvePrimary: true,
                approveSecondary: true,
                approveSupport: true,
                enforceCharacterLimits: true,
                characterLimit: 5,
                autoAvailabilityForPrimary: true,
                autoAvailabilityForSecondary: true,
                autoAvailabilityForSupport: false
            ),
            'discord' => Discord::from([
                'webhook' => null,
                'color' => '#38b2ac',
            ]),
            'posting_activity' => new PostingActivity(
                postsStrategy: 'author',
                trackingStrategy: 'words',
                requiredActivity: 1000,
                wordCountPostConversion: 500,
                wordCountStrategy: 'average'
            ),
            'ratings' => new ContentRatings(
                language: new ContentRating(
                    rating: 1,
                    description_0: 'No profanity permitted.',
                    description_1: 'Infrequent or mild profanity permitted.',
                    description_2: 'Profanity permitted, with some limitations.',
                    description_3: 'Heavy profanity and mature language permitted.',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain heavy profanity and mature language.',
                ),
                sex: new ContentRating(
                    rating: 1,
                    description_0: 'No sexual content permitted.',
                    description_1: 'Mild sexual innuendo and references permitted.',
                    description_2: 'Sexual content permitted, with some limitations.',
                    description_3: 'Explicit sexual content permitted.',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit sexual content.',
                ),
                violence: new ContentRating(
                    rating: 1,
                    description_0: 'No violence permitted.',
                    description_1: 'Mild violence permitted.',
                    description_2: 'Violence permitted, with some limitations.',
                    description_3: 'Explicit violence permitted.',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit violence.',
                ),
            ),
        ];

        $defaults = new Settings(array_merge([
            'key' => 'default',
        ], $settings));
        $defaults->save();

        $custom = new Settings(array_merge([
            'key' => 'custom',
        ], $settings));
        $custom->save();
    }

    public function down()
    {
        Settings::truncate();
    }
}
