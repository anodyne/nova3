<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\PostTypes\Data\Field;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Models\PostType;
use Nova\Roles\Models\Role;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\Story;

class PopulateStoryTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populatePostTypes();

        $this->populateStoryTimelineRoot();

        activity()->enableLogging();
    }

    public function down()
    {
        PostType::truncate();
    }

    protected function populatePostTypes()
    {
        $storyManager = Role::where('name', 'story-manager')->first();

        $postTypes = [
            [
                'name' => 'Story Post',
                'key' => 'post',
                'description' => 'A post that drives the story forward. It can be a singular post or a collaborative post with other characters in the game.',
                'color' => '#05a2c2',
                'icon' => 'book',
                'visibility' => 'in-character',
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'validate' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostTracking' => true,
                    'multipleAuthors' => true,
                ]),
                'sort' => 0,
            ],

            [
                'name' => 'Journal Entry',
                'key' => 'personal',
                'description' => 'A post more geared toward telling the perspective of individual characters. This can often be thought of as an inner monologue or journal entry.',
                'color' => '#46a758',
                'icon' => 'user',
                'visibility' => 'in-character',
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'validate' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostTracking' => true,
                    'multipleAuthors' => false,
                ]),
                'sort' => 1,
            ],

            [
                'name' => 'Marker',
                'key' => 'marker',
                'description' => 'Mark time or location for the story to give players an indication that the action has moved location or timeframes.',
                'color' => '#e93d82',
                'icon' => 'location',
                'visibility' => 'out-of-character',
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'validate' => true,
                    ]),
                    'day' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'rating' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifyUsers' => false,
                    'notifyDiscord' => false,
                    'includeInPostTracking' => false,
                    'multipleAuthors' => false,
                ]),
                'role_id' => $storyManager->id,
                'sort' => 2,
            ],

            [
                'name' => 'Note',
                'key' => 'note',
                'description' => 'Inform players of key pieces of information about the story in a single place. Players will be able to see all notes when composing a new story post.',
                'color' => '#ab4aba',
                'icon' => 'lightbulb',
                'visibility' => 'out-of-character',
                'fields' => Fields::from([
                    'title' => Field::from([
                        'enabled' => true,
                        'validate' => false,
                    ]),
                    'day' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                    'time' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                    'location' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                    'content' => Field::from([
                        'enabled' => true,
                        'validate' => true,
                    ]),
                    'rating' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                    'summary' => Field::from([
                        'enabled' => false,
                        'validate' => false,
                    ]),
                ]),
                'options' => Options::from([
                    'notifyUsers' => false,
                    'notifyDiscord' => true,
                    'includeInPostTracking' => false,
                    'multipleAuthors' => false,
                ]),
                'role_id' => $storyManager->id,
                'sort' => 3,
            ],
        ];

        PostType::unguarded(function () use ($postTypes) {
            collect($postTypes)->each([PostType::class, 'create']);
        });
    }

    protected function populateStoryTimelineRoot()
    {
        Story::create([
            'title' => 'Main Timeline',
            'status' => Completed::class,
        ]);
    }
}
