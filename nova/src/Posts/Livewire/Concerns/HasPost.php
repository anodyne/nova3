<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Arr;
use Nova\Posts\Models\Post;

trait HasPost
{
    public ?int $postId = null;

    public mixed $post = null;

    public function mountHasPost(): void
    {
        $this->post = request()->route()->post;

//        dd($this->post->toArray());

        if ($this->post === null) {
            $data = Arr::get(
                $this->state()->forStep('posts:step:setup-post'),
                'postId'
            );

            $this->post = Post::query()->firstOrCreate(['id' => $data]);
        }

        $this->postId = $this->post->id;
    }
}
