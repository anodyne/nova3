<?php

namespace Nova\Posts\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Posts\Models\Post;

class WritePost extends SpotlightCommand
{
    protected string $name = 'Write Post';

    protected string $description = 'Start a new story post';

    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('posts.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Post::class);
    }
}
