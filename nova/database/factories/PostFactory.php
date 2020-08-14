<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Nova\Posts\Models\Post;
use Faker\Generator as Faker;
use Nova\Stories\Models\Story;
use Nova\PostTypes\Models\PostType;
use Nova\Posts\Models\States\Published;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'post_type_id' => fn () => factory(PostType::class)->create(),
        'story_id' => fn () => factory(Story::class)->create(),
        'content' => $faker->paragraphs(5, true),
        'status' => Published::class,
    ];
});
