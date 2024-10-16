<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\PostType;

class ViewPostTypes extends SpotlightCommand
{
    protected string $name = 'View Post Types';

    protected string $description = 'View all post types';

    protected array $synonyms = [
        'show all post types',
        'display all post types',
        'list all post types',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.post-types.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', PostType::class);
    }
}
