<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;

trait HasPost
{
    public ?int $postId = null;

    public mixed $post = null;

    public function mountHasPost(): void
    {
        $this->post = request()->route()->post;

        if ($this->post === null) {
            $data = data_get(
                $this->state()->forStep('posts:step:setup-post'),
                'postId'
            );

            $this->post = Post::firstOrCreate(['id' => $data]);

            if (request()->has('neighbor')) {
                $this->post->update([
                    'direction' => request('direction', 'after'),
                    'neighbor' => request('neighbor'),
                ]);

                $this->post = SetPostPosition::run(
                    $this->post,
                    PostPositionData::from([
                        'direction' => request('direction', 'after'),
                        'neighbor' => request('neighbor'),
                        'hasPositionChange' => true,
                    ])
                );
            }
        }

        $this->post->loadMissing('story', 'postType');

        $this->postId = $this->post->id;
    }
}
