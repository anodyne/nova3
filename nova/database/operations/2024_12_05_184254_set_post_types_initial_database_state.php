<?php

declare(strict_types=1);

use Nova\Foundation\Icons\Icon;
use Nova\Roles\Models\Role;
use Nova\Stories\Data\Field;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Models\PostType;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        activity()->disableLogging();

        $this->populatePostTypes();

        activity()->enableLogging();
    }

    protected function populatePostTypes()
    {
        $storyManager = Role::where('name', 'story-manager')->first();

        $postTypes = [
            [
                'name' => 'Story Post',
                'key' => 'post',
                'description' => 'A post that drives the story forward. It can be a singular post or a collaborative post with other characters in the game.',
                'color' => '#0ea5e9',
                'icon' => Icon::BookClosed,
                'visibility' => PostTypeVisibility::InCharacter,
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'required' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifiesUsers' => true,
                    'includedInPostTracking' => true,
                    'allowsMultipleAuthors' => true,
                    'allowsCharacterAuthors' => true,
                    'allowsUserAuthors' => true,
                    'showContentInTimelineView' => false,
                    'editTimeframe' => PostEditTimeframe::Hour4->value,
                ]),
                'order_column' => 0,
            ],

            [
                'name' => 'Journal Entry',
                'key' => 'personal',
                'description' => 'A post more geared toward telling the perspective of individual characters. This can often be thought of as an inner monologue or journal entry.',
                'color' => '#10b981',
                'icon' => Icon::AddressBook,
                'visibility' => PostTypeVisibility::InCharacter,
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'required' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifiesUsers' => true,
                    'includedInPostTracking' => true,
                    'allowsMultipleAuthors' => false,
                    'allowsCharacterAuthors' => true,
                    'allowsUserAuthors' => true,
                    'showContentInTimelineView' => false,
                    'editTimeframe' => PostEditTimeframe::Hour4->value,
                ]),
                'order_column' => 1,
            ],

            [
                'name' => 'Marker',
                'key' => 'marker',
                'description' => 'Mark time or location for the story to give players an indication that the action has moved location or timeframes.',
                'color' => '#ec4899',
                'icon' => Icon::Location,
                'visibility' => PostTypeVisibility::OutOfCharacter,
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'required' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifiesUsers' => false,
                    'includedInPostTracking' => false,
                    'allowsMultipleAuthors' => false,
                    'allowsCharacterAuthors' => false,
                    'allowsUserAuthors' => true,
                    'showContentInTimelineView' => true,
                    'editTimeframe' => PostEditTimeframe::Hour4->value,
                ]),
                'role_id' => $storyManager->id,
                'order_column' => 2,
            ],

            [
                'name' => 'Note',
                'key' => 'note',
                'description' => 'Inform players of key pieces of information about the story in a single place. Players will be able to see all notes when composing a new story post.',
                'color' => '#a855f7',
                'icon' => Icon::Bulb,
                'visibility' => PostTypeVisibility::OutOfCharacter,
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'required' => false,
                    ]),
                    'day' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'required' => true,
                    ]),
                    'rating' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => false,
                        'required' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifiesUsers' => false,
                    'includedInPostTracking' => false,
                    'allowsMultipleAuthors' => false,
                    'allowsCharacterAuthors' => false,
                    'allowsUserAuthors' => true,
                    'showContentInTimelineView' => true,
                    'editTimeframe' => PostEditTimeframe::Hour4->value,
                ]),
                'role_id' => $storyManager->id,
                'order_column' => 3,
            ],
        ];

        PostType::unguarded(function () use ($postTypes) {
            collect($postTypes)->each([PostType::class, 'create']);
        });
    }
};
