<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\Story;

class KhitomerSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        PostAuthor::truncate();
        Post::truncate();
        Story::truncate();

        $this->call([
            KhitomerStorySeeder::class,
            KhitomerPostSeeder::class,
        ]);

        activity()->enableLogging();
    }
}
