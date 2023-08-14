<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class PostSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Story::get()
            ->each(function ($story) {
                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 1',
                    'order_column' => 0,
                ]);

                $post = Post::factory()->published()->marker()->create([
                    'story_id' => $story->id,
                    'title' => 'Start of Day 2',
                    'day' => 'Day 2',
                    'time' => '0000 hours',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla laudantium voluptatem, ad nam necessitatibus, doloremque ipsam sunt fugit earum eum debitis molestias inventore accusantium explicabo veritatis quas aliquid consectetur modi!',
                    'order_column' => 1,
                ]);

                $post = Post::factory()->draft()->personal()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                    'order_column' => 2,
                ]);

                $post = Post::factory()->published()->note()->create([
                    'story_id' => $story->id,
                    'title' => 'Story Note',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, incidunt laboriosam ea vero natus porro veniam consectetur officiis, doloribus temporibus aperiam autem voluptatibus ad recusandae quia! Ratione dicta eaque at!',
                    'order_column' => 3,
                ]);

                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                    'order_column' => 4,
                ]);

                $post = Post::factory()->draft()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                    'order_column' => 5,
                ]);

                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                    'order_column' => 6,
                ]);
            });

        activity()->enableLogging();
    }
}
