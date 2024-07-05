<?php

declare(strict_types=1);

namespace Nova\Conversations\Providers;

use Nova\Conversations\Livewire\ConversationMessages;
use Nova\Conversations\Livewire\ConversationsList;
use Nova\Conversations\Models\Conversation;
use Nova\DomainServiceProvider;

class ConversationServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'conversations-messages' => ConversationMessages::class,
            'conversations-list' => ConversationsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'conversation' => Conversation::class,
        ];
    }
}
