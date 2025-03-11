<?php

declare(strict_types=1);

namespace Nova\Discussions\Providers;

use Nova\Discussions\Livewire\ComposeMessage;
use Nova\Discussions\Livewire\MessageHistory;
use Nova\Discussions\Livewire\MessagesList;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\DomainServiceProvider;

class DiscussionServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'discussions-message-history' => MessageHistory::class,
            'discussions-messages-list' => MessagesList::class,
            'discussions-compose-message-modal' => ComposeMessage::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'discussion' => Discussion::class,
            'discussion-message' => DiscussionMessage::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'dis_' => Discussion::class,
        ];
    }
}
