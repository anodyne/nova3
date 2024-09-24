<?php

declare(strict_types=1);

namespace Nova\Discussions\Providers;

use Nova\Discussions\Livewire\ComposeDirectMessage;
use Nova\Discussions\Livewire\ComposeGroupMessage;
use Nova\Discussions\Livewire\MessageHistory;
use Nova\Discussions\Livewire\MessagesList;
use Nova\Discussions\Models\Discussion;
use Nova\DomainServiceProvider;

class DiscussionServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'discussions-message-history' => MessageHistory::class,
            'discussions-messages-list' => MessagesList::class,
            'discussions-compose-direct-message-modal' => ComposeDirectMessage::class,
            'discussions-compose-group-message-modal' => ComposeGroupMessage::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'dis_' => Discussion::class,
        ];
    }
}
