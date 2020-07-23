<?php

use Nova\Stories\Models\Story;
use Nova\PostTypes\Models\PostType;
use Illuminate\Database\Migrations\Migration;
use Nova\PostTypes\DataTransferObjects\Fields;
use Nova\PostTypes\DataTransferObjects\Options;
use Nova\Stories\Models\States\Stories\Completed;

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
                'description' => '',
                'visibility' => 'in-character',
                'fields' => new Fields([
                    'title' => true,
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
                'description' => '',
                'visibility' => 'in-character',
                'fields' => new Fields([
                    'title' => true,
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
                'description' => 'A marker allows you to mark time or location for the story to give players an indication that the story has moved location or timeframes.',
                'visibility' => 'out-of-character',
                'fields' => new Fields([
                    'title' => false,
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
                'description' => 'A story note is a way to inform players of key pieces of information about the ongoing story in one place.',
                'visibility' => 'out-of-character',
                'fields' => new Fields([
                    'title' => false,
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

        collect($postTypes)->each([PostType::class, 'create']);
    }

    protected function populateStoryTimelineRoot()
    {
        Story::create([
            'title' => 'Timeline',
            'status' => Completed::class,
        ]);
    }
}
