<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\Post;

class WritePost extends SpotlightCommand
{
    protected string $name = 'Write Post';

    protected string $description = 'Start a new story post';

    /** @var list<string> */
    protected array $synonyms = [
        'compose post', 'create post',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.posts.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Post::class);
    }
}
