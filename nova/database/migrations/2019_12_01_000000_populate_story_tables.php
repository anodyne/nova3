<?php

use Nova\PostTypes\Models\PostType;
use Illuminate\Database\Migrations\Migration;

class PopulateStoryTables extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populatePostTypes();

        activity()->enableLogging();
    }

    public function down()
    {
        PostType::truncate();
    }

    protected function populatePostTypes()
    {
        $postTypes = [
            ['name' => 'Story Post', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius officia libero asperiores optio enim. Odit adipisci cum possimus? Minima omnis asperiores nemo provident accusamus doloribus, quaerat id! Quidem, tenetur sunt!', 'key' => 'post', 'sort' => 0],
            ['name' => 'Personal Post', 'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius officia libero asperiores optio enim. Odit adipisci cum possimus? Minima omnis asperiores nemo provident accusamus doloribus, quaerat id! Quidem, tenetur sunt!', 'key' => 'personal', 'sort' => 1],
            ['name' => 'Marker', 'description' => 'A marker allows you to mark time or location for the story to give players an indication that the story has moved location or timeframes.', 'key' => 'marker', 'sort' => 2],
            [
                'name' => 'Note',
                'key' => 'note',
                'description' => 'A story note is a way to inform players of key pieces of information about the ongoing story in one place.',
                'visibility' => 'out-of-character',
                'sort' => 3,
            ],
        ];

        collect($postTypes)->each([PostType::class, 'create']);
    }
}
