<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\PostType;

class AddPostType extends SpotlightCommand
{
    protected string $name = 'Add Post Type';

    protected string $description = 'Add a new post type';

    protected array $synonyms = [
        'create new post type',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.post-types.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', PostType::class);
    }
}
