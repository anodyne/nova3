<?php

use Nova\Stories\Models\Story;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\States\Completed;
use Illuminate\Database\Migrations\Migration;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;

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
        $postTypes = [
            [
                'name' => 'Story Post',
                'key' => 'post',
                'description' => 'A post that drives the story forward. It can be a singular post or a collaborative post with other characters in the game.',
                'color' => '#76a9fa',
                'icon' => 'book',
                'visibility' => 'in-character',
                'fields' => new Fields([
                    'title' => true,
                    'day' => true,
                    'time' => true,
                    'location' => true,
                    'content' => true,
                ]),
                'options' => new Options([
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => true,
                    'multipleAuthors' => true,
                ]),
                'sort' => 0,
            ],

            [
                'name' => 'Personal Post',
                'key' => 'personal',
                'description' => 'A post more geared toward telling the perspective of individual characters. This can often be thought of as an inner monologue or journal entry.',
                'color' => '#31c48d',
                'icon' => 'user',
                'visibility' => 'in-character',
                'fields' => new Fields([
                    'title' => true,
                    'day' => true,
                    'time' => true,
                    'location' => false,
                    'content' => true,
                ]),
                'options' => new Options([
                    'notifyUsers' => true,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => true,
                    'multipleAuthors' => false,
                ]),
                'sort' => 1,
            ],

            [
                'name' => 'Marker',
                'key' => 'marker',
                'description' => 'Mark time or location for the story to give players an indication that the action has moved location or timeframes.',
                'color' => '#ff8a4c',
                'icon' => 'location',
                'visibility' => 'out-of-character',
                'fields' => new Fields([
                    'title' => false,
                    'day' => true,
                    'time' => true,
                    'location' => true,
                    'content' => false,
                ]),
                'options' => new Options([
                    'notifyUsers' => false,
                    'notifyDiscord' => false,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => false,
                ]),
                'role_id' => 1,
                'sort' => 2,
            ],

            [
                'name' => 'Note',
                'key' => 'note',
                'description' => 'Inform players of key pieces of information about the story in a single place. Players will be able to see all notes when composing a new story post.',
                'color' => '#ac94fa',
                'icon' => 'note',
                'visibility' => 'out-of-character',
                'fields' => new Fields([
                    'title' => false,
                    'day' => false,
                    'time' => false,
                    'location' => false,
                    'content' => true,
                ]),
                'options' => new Options([
                    'notifyUsers' => false,
                    'notifyDiscord' => true,
                    'includeInPostCounts' => false,
                    'multipleAuthors' => false,
                ]),
                'role_id' => 1,
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
