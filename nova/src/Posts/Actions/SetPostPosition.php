<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;

class SetPostPosition
{
    use AsAction;

    public function handle(Post $post, PostPositionData $data): Post
    {
        $rootPost = Post::whereStory($post->story_id)
            ->whereIsRoot()
            ->first();

        if (! $post->parent) {
            $rootPost->appendNode($post);
        }

        if ($data->hasPositionChange) {
            if ($data->direction && $data->neighbor) {
                // $method = "{$data->direction}Node";

                // $post->{$method}($data->neighbor)->save();

                Post::query()
                    ->whereStory($post->story->id)
                    ->where('sort', $data->direction === 'before' ? '>=' : '>', $data->neighbor->sort)
                    ->increment('sort');

                $post->update(['sort' => $data->direction === 'before' ? $data->neighbor->sort : $data->neighbor->sort + 1]);
            }
        }

        return $post->refresh();
    }
}
