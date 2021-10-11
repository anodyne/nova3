<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class PostSeeder extends Seeder
{
    public function run()
    {
        Story::where('id', '>', 1)
            ->get()
            ->each(function ($story) {
                $rootPost = CreateRootPost::run($story);

                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 1',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->published()->marker()->create([
                    'story_id' => $story->id,
                    'title' => 'Start of Day 2',
                    'day' => 'Day 2',
                    'time' => '0000 hours',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla laudantium voluptatem, ad nam necessitatibus, doloremque ipsam sunt fugit earum eum debitis molestias inventore accusantium explicabo veritatis quas aliquid consectetur modi!',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->draft()->personal()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->published()->note()->create([
                    'story_id' => $story->id,
                    'title' => 'Story Note',
                    'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, incidunt laboriosam ea vero natus porro veniam consectetur officiis, doloribus temporibus aperiam autem voluptatibus ad recusandae quia! Ratione dicta eaque at!',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->draft()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                ]);
                $post->appendToNode($rootPost)->save();

                $post = Post::factory()->published()->post()->create([
                    'story_id' => $story->id,
                    'day' => 'Day 2',
                ]);
                $post->appendToNode($rootPost)->save();
            });
    }
}
