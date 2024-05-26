<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Data\Characters;
use Nova\Settings\Data\ContentRating;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Data\Discord;
use Nova\Settings\Data\Email;
use Nova\Settings\Data\FontFamilies;
use Nova\Settings\Data\General;
use Nova\Settings\Data\MetaTags;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Models\Settings;
use Nova\Setup\Randomize;

class PopulateSettingsTable extends Migration
{
    public function up()
    {
        $settings = [
            'general' => new General(
                gameName: 'USS Nova',
                dateFormat: '#month_short# #day_num2#, #year_long#',
                dateFormatTags: '[[{"value":"#month_short#","text":"Month, short (Sep)","prefix":"#"}]] [[{"value":"#day_num2#","text":"Day, numeric leading zero (12)","prefix":"#"}]], [[{"value":"#year_long#","text":"Year, long (2023)","prefix":"#"}]]',
            ),
            'email' => new Email(
                subjectPrefix: null,
                replyTo: null,
                imagePath: null,
            ),
            'appearance' => new Appearance(
                theme: Randomize::theme(),
                avatarShape: Randomize::avatarShape(),
                avatarStyle: Randomize::avatarStyle(),
                imagePath: null,
                colorsGray: 'Gray',
                colorsPrimary: 'Sky',
                colorsDanger: 'Rose',
                colorsWarning: 'Amber',
                colorsSuccess: 'Emerald',
                colorsInfo: 'Purple',
                adminFonts: new FontFamilies(
                    headerProvider: 'local',
                    headerFamily: 'Inter',
                    bodyProvider: 'local',
                    bodyFamily: 'Inter'
                ),
                panda: false
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
                    description_0: 'Does not contain profanity',
                    description_1: 'Infrequent, light profanity',
                    description_2: 'Mild profanity',
                    description_3: 'Heavy profanity and mature language',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain heavy profanity and mature language',
                ),
                sex: new ContentRating(
                    rating: 1,
                    description_0: 'Does not contain sexual content',
                    description_1: 'Mild sexual innuendo and references',
                    description_2: 'Sexual content and situations',
                    description_3: 'Explicit sexual content',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit sexual content',
                ),
                violence: new ContentRating(
                    rating: 1,
                    description_0: 'Does not contain violence',
                    description_1: 'Mild violence',
                    description_2: 'Heavy violence',
                    description_3: 'Explicit violence',
                    warning_threshold: 2,
                    warning_threshold_message: 'May contain explicit violence',
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
