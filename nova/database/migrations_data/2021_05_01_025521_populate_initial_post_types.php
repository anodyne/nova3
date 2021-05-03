<?php

use Illuminate\Database\Migrations\Migration;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Values;

class PopulateInitialPostTypes extends Migration
{
    public function up(): void
    {
        PostType::unguarded(function () {
            collect([
                $this->storyPost(),
                $this->journeyEntry(),
                $this->marker(),
                $this->note(),
            ])->each([PostType::class, 'create']);
        });
    }

    public function down(): void
    {
        PostType::whereIn('key', [
            $this->storyPost()['key'],
            $this->journeyEntry()['key'],
            $this->marker()['key'],
            $this->note()['key'],
        ])->delete();
    }

    public function storyPost(): array
    {
        return [
            'name' => 'Story Post',
            'key' => 'post',
            'description' => 'A post that drives the story forward. It can be a singular post or a collaborative post with other characters in the game.',
            'color' => '#76a9fa',
            'icon' => 'book',
            'visibility' => 'in-character',
            'fields' => new Values\Fields([
                'title' => new Values\Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => false,
                ]),
                'day' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'time' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'location' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'content' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'rating' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
            ]),
            'options' => new Values\Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostCounts' => true,
                'multipleAuthors' => true,
            ]),
            'sort' => 0,
        ];
    }

    public function journeyEntry(): array
    {
        return [
            'name' => 'Journal Entry',
            'key' => 'personal',
            'description' => 'A post more geared toward telling the perspective of individual characters. This can often be thought of as an inner monologue or journal entry.',
            'color' => '#31c48d',
            'icon' => 'user',
            'visibility' => 'in-character',
            'fields' => new Values\Fields([
                'title' => new Values\Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => false,
                ]),
                'day' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'time' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'location' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => true,
                ]),
                'content' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'rating' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
            ]),
            'options' => new Values\Options([
                'notifyUsers' => true,
                'notifyDiscord' => true,
                'includeInPostCounts' => true,
                'multipleAuthors' => false,
            ]),
            'sort' => 1,
        ];
    }

    public function marker(): array
    {
        return [
            'name' => 'Marker',
            'key' => 'marker',
            'description' => 'Mark time or location for the story to give players an indication that the action has moved location or timeframes.',
            'color' => '#ff8a4c',
            'icon' => 'location',
            'visibility' => 'out-of-character',
            'fields' => new Values\Fields([
                'title' => new Values\Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => false,
                ]),
                'day' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'time' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'location' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'content' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'rating' => new Values\Field([
                    'enabled' => false,
                    'validate' => false,
                    'suggest' => false,
                ]),
            ]),
            'options' => new Values\Options([
                'notifyUsers' => false,
                'notifyDiscord' => false,
                'includeInPostCounts' => false,
                'multipleAuthors' => false,
            ]),
            'role_id' => 1,
            'sort' => 2,
        ];
    }

    public function note(): array
    {
        return [
            'name' => 'Note',
            'key' => 'note',
            'description' => 'Inform players of key pieces of information about the story in a single place. Players will be able to see all notes when composing a new story post.',
            'color' => '#ac94fa',
            'icon' => 'lightbulb',
            'visibility' => 'out-of-character',
            'fields' => new Values\Fields([
                'title' => new Values\Field([
                    'enabled' => true,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'day' => new Values\Field([
                    'enabled' => false,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'time' => new Values\Field([
                    'enabled' => false,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'location' => new Values\Field([
                    'enabled' => false,
                    'validate' => false,
                    'suggest' => false,
                ]),
                'content' => new Values\Field([
                    'enabled' => true,
                    'validate' => true,
                    'suggest' => false,
                ]),
                'rating' => new Values\Field([
                    'enabled' => false,
                    'validate' => false,
                    'suggest' => false,
                ]),
            ]),
            'options' => new Values\Options([
                'notifyUsers' => false,
                'notifyDiscord' => true,
                'includeInPostCounts' => false,
                'multipleAuthors' => false,
            ]),
            'role_id' => 1,
            'sort' => 3,
        ];
    }
}
