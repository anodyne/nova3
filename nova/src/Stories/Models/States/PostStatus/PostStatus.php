<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PostStatus extends State
{
    abstract public function color(): string;

    abstract public function name(): string;

    public function displayName(): string
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
