<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Livewire\Attributes\Reactive;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\Story;

trait HasParentState
{
    #[Reactive]
    public ?int $postId = null;

    #[Reactive]
    public ?PostType $postType = null;

    #[Reactive]
    public ?Story $story = null;
}
