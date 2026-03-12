<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $now = Date::now();

            $storyManagerId = DB::table('roles')->where('name', 'story-manager')->value('id');

            $postTypes = [
                [
                    'name' => 'Story Post',
                    'key' => 'post',
                    'description' => 'A post that drives the story forward. It can be a singular post or a collaborative post with other characters in the game.',
                    'color' => '#0ea5e9',
                    'icon' => 'tabler-book-2',
                    'visibility' => 'in-character',
                    'fields' => [
                        'title' => ['enabled' => true, 'required' => true],
                        'day' => ['enabled' => true, 'required' => false],
                        'time' => ['enabled' => true, 'required' => false],
                        'location' => ['enabled' => true, 'required' => false],
                        'content' => ['enabled' => true, 'required' => false],
                        'rating' => ['enabled' => true, 'required' => false],
                        'summary' => ['enabled' => true, 'required' => false],
                    ],
                    'options' => [
                        'notifiesUsers' => true,
                        'includedInPostTracking' => true,
                        'allowsMultipleAuthors' => true,
                        'allowsCharacterAuthors' => true,
                        'allowsUserAuthors' => true,
                        'showContentInTimelineView' => false,
                        'editTimeframe' => '4h',
                    ],
                    'role_id' => null,
                    'order_column' => 0,
                ],
                [
                    'name' => 'Journal Entry',
                    'key' => 'personal',
                    'description' => 'A post more geared toward telling the perspective of individual characters. This can often be thought of as an inner monologue or journal entry.',
                    'color' => '#10b981',
                    'icon' => 'tabler-address-book',
                    'visibility' => 'in-character',
                    'fields' => [
                        'title' => ['enabled' => true, 'required' => true],
                        'day' => ['enabled' => true, 'required' => false],
                        'time' => ['enabled' => true, 'required' => false],
                        'location' => ['enabled' => true, 'required' => false],
                        'content' => ['enabled' => true, 'required' => false],
                        'rating' => ['enabled' => true, 'required' => false],
                        'summary' => ['enabled' => true, 'required' => false],
                    ],
                    'options' => [
                        'notifiesUsers' => true,
                        'includedInPostTracking' => true,
                        'allowsMultipleAuthors' => false,
                        'allowsCharacterAuthors' => true,
                        'allowsUserAuthors' => true,
                        'showContentInTimelineView' => false,
                        'editTimeframe' => '4h',
                    ],
                    'role_id' => null,
                    'order_column' => 1,
                ],
                [
                    'name' => 'Marker',
                    'key' => 'marker',
                    'description' => 'Mark time or location for the story to give players an indication that the action has moved location or timeframes.',
                    'color' => '#ec4899',
                    'icon' => 'tabler-map-pin',
                    'visibility' => 'out-of-character',
                    'fields' => [
                        'title' => ['enabled' => true, 'required' => true],
                        'day' => ['enabled' => true, 'required' => false],
                        'time' => ['enabled' => true, 'required' => false],
                        'location' => ['enabled' => true, 'required' => false],
                        'content' => ['enabled' => true, 'required' => false],
                        'rating' => ['enabled' => false, 'required' => false],
                        'summary' => ['enabled' => false, 'required' => false],
                    ],
                    'options' => [
                        'notifiesUsers' => false,
                        'includedInPostTracking' => false,
                        'allowsMultipleAuthors' => false,
                        'allowsCharacterAuthors' => false,
                        'allowsUserAuthors' => true,
                        'showContentInTimelineView' => true,
                        'editTimeframe' => '4h',
                    ],
                    'role_id' => $storyManagerId,
                    'order_column' => 2,
                ],
                [
                    'name' => 'Note',
                    'key' => 'note',
                    'description' => 'Inform players of key pieces of information about the story in a single place. Players will be able to see all notes when composing a new story post.',
                    'color' => '#a855f7',
                    'icon' => 'tabler-bulb',
                    'visibility' => 'out-of-character',
                    'fields' => [
                        'title' => ['enabled' => true, 'required' => false],
                        'day' => ['enabled' => false, 'required' => false],
                        'time' => ['enabled' => false, 'required' => false],
                        'location' => ['enabled' => false, 'required' => false],
                        'content' => ['enabled' => true, 'required' => true],
                        'rating' => ['enabled' => false, 'required' => false],
                        'summary' => ['enabled' => false, 'required' => false],
                    ],
                    'options' => [
                        'notifiesUsers' => false,
                        'includedInPostTracking' => false,
                        'allowsMultipleAuthors' => false,
                        'allowsCharacterAuthors' => false,
                        'allowsUserAuthors' => true,
                        'showContentInTimelineView' => true,
                        'editTimeframe' => '4h',
                    ],
                    'role_id' => $storyManagerId,
                    'order_column' => 3,
                ],
            ];

            $jsonColumns = ['fields', 'options'];

            $template = [
                'name' => null,
                'key' => null,
                'description' => null,
                'color' => null,
                'icon' => null,
                'visibility' => null,
                'fields' => null,
                'options' => null,
                'role_id' => null,
                'order_column' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $rows = [];
            foreach ($postTypes as $postType) {
                foreach ($jsonColumns as $column) {
                    if (array_key_exists($column, $postType) && is_array($postType[$column])) {
                        $postType[$column] = json_encode($postType[$column], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                }

                $rows[] = array_replace($template, $postType, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('post_types')->upsert(
                $rows,
                ['key'],
                ['name', 'description', 'color', 'icon', 'visibility', 'fields', 'options', 'role_id', 'order_column', 'updated_at']
            );
        });
    }

    public function down(): void
    {
        DB::table('post_types')->truncate();
    }
};
