<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Nova\Stories\Models\Post;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/** @extends State<Post> */
abstract class PostStatus extends State implements HasColor, HasLabel
{
    abstract public function getColor(): string;

    abstract public function name(): string;

    public function getLabel(): string
    {
        return ucfirst($this->name());
    }

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Started::class)
            ->allowTransitions([
                [Started::class, Draft::class, StartedToDraft::class],
                [Draft::class, Pending::class, DraftToPending::class],
                [Draft::class, Published::class, DraftToPublished::class],
                [Pending::class, Published::class, PendingToPublished::class],
            ]);
    }
}
